<?php namespace App;

use App\HolidayRequest;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use \Exception as Exception;
use Laracasts\Flash\Flash;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $appends = [
		'avatar_path',
		'url',
		'department_name'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token'
	];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'first_name',
		'last_name',
		'slug',
		'role',
		'email',
		'password',
		'telephone',
		'extension',
		'skype_name',
		'department_id',
		'location_id',
		'super_user',
		'annual_holiday_allowance'
	];

	public $default_annual_holiday_alowance = 25;
	public $active_holiday_balance 			= 0;
	public $pending_holiday_balance 		= 0;
	public $approved_holiday_balance 		= 0;
	public $completed_holiday_balance 		= 0;
	public $available_holiday_balance 		= 0;
	public $unavailable_holiday_balance 	= 0;
	public $avatarPathAttribute;

	// Relationships
	public function department()
	{
		return $this->belongsTo('App\Department', 'department_id', 'id');
	}

	public function location()
	{
		return $this->belongsTo('App\Location', 'location_id', 'id');
	}

	public function holidayRequests()
	{
		//return $this->hasMany(HolidayRequest::class);
	}

	/**
	 * Concatenate the First and Last name values
	 *
	 * @return string
	 */
	public function fullName()
	{
		return $this->first_name.' '.$this->last_name;
	}

	/**
	 * Is this user a Department Lead
	 *
	 * @return bool
	 * @param Department $department
	 */
	public function isDepartmentLead(Department $department)
	{
		return $department->lead_id == $this->id;
	}

	public function leadDepartment()
	{
		if ($this->isDepartmentLead($this->department)) {
			return $this->department;
		}

		return false;
	}

	/**
	 * Is this user regarded as a Super User
	 * This will generally be a user that can manage multiple Teams
	 *
	 * @return bool
	 */
	public function isSuperUser()
	{
		return $this->super_user == 1;
	}

	/**
	 * Can this User manage Departments
	 * Generally they will be a Department Lead but this may be extended to allow Team Leads to deputise
	 * There is possibly a Super User that can manage in the absence of relevant Department Lead
	 *
	 * @return bool
	 * @param Department $department
	 */
	public function hasManageDepartmentPermission(Department $department = null)
	{
		return $this->isSuperUser() || $this->isDepartmentLead($department);
	}

	/**
	 * Return path to the users's gravatar image
	 * If none has been set, the default image path will be returned
	 * A size can be specified if it is required to overwrite the default 200
	 *
	 * @return string
	 * @param int $size
	 * @param string $default
	 */
	public function getAvatarPath($size = 150, $default = 'mm')
	{
		$str = md5(trim(strtolower($this->email)));

		return 'http://www.gravatar.com/avatar/'.$str.'?s='.$size.'&d='.$default;
	}

	public function getAvatarPathAttribute($size = 150, $default = 'mm')
	{
		$str = md5(trim(strtolower($this->email)));

		return 'http://www.gravatar.com/avatar/'.$str.'?d='.$default.'&s='.$size;
	}

	public function getUrlAttribute()
	{
		return '/member/'.$this->slug;
	}

	public function getDepartmentNameAttribute()
	{
		return $this->department->name;
	}

	public function sendConfirmationRequestEmail()
	{
		var_dump('Send a mail containing the token : '.$this->confirmation_token);
	}

	/**
	 * The user has successfully confirmed their account
	 * The confirmed flag is set to true
	 * The confirmation_flag is no longer needed so set to null
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function confirmAccount()
	{
		$this->confirmed 			= true;
		$this->confirmation_token 	= null;

		$this->save();
	}

	/**
	 * Place the holiday Request
	 *
	 * @return bool
	 * @param HolidayRequest $holiday_request
	 */
	public function addHolidayRequest(HolidayRequest $holiday_request)
	{
		if ($this->validateHolidayRequest()) {
			return $holiday_request->place();
		}

		return false;
	}

	/**
	 * Cancel an existing holiday request
	 *
	 * @throws Exception
	 * @return bool
	 * @param HolidayRequest $holiday_request
	 */
	public function cancelHolidayRequest(HolidayRequest $holiday_request)
	{
		return $holiday_request->cancel();
	}

	/**
	 * If no allowance has been specified, use the Company default
	 *
	 * @return int|mixed
	 */
	public function getAnnualHolidayAllowance()
	{
		if ( ! empty($this->annual_holiday_allowance))
		{
			return $this->annual_holiday_allowance;
		}

		return $this->default_annual_holiday_alowance;
	}

	/**
	 * Create a summary of balances of all holiday statuses
	 *
	 * @return array
	 */
	public function getHolidayBalanceSummary()
	{
		return [
			'Annual Allowance'  => $this->getAnnualHolidayAllowance(),
			'Completed Holiday' => $this->completedHolidayBalance(),
			'Active Holiday'    => $this->activeHolidayBalance(),
			'Pending Requests'  => $this->pendingHolidayBalance(),
			'Approved Requests' => $this->approvedHolidayBalance(),
			'Available Balance' => $this->availableHolidayAllowance(),
		];
	}

	/**
	 * How many days holiday are already accounted for
	 * This will be the annual allowance minus active, approved, pending and completed requests
	 *
	 * @return mixed
	 */
	public function unavailableHolidayBalance()
	{
		return ($this->pendingHolidayBalance() + $this->approvedHolidayBalance() + $this->activeHolidayBalance() + $this->completedHolidayBalance());
	}

	/**
	 * How many days holiday are still available
	 *
	 * @return mixed
	 */
	public function availableHolidayAllowance()
	{
		return $this->getAnnualHolidayAllowance() - $this->unavailableHolidayBalance();
	}

	public function pendingHolidayBalance()
	{
		// @TODO Ensure that returned requests are for the current year
		return $this->pending_holiday_balance;
	}

	public function approvedHolidayBalance()
	{
		return $this->approved_holiday_balance;
	}

	public function declinedHolidayBalance()
	{
		return 0;
	}

	public function activeHolidayBalance()
	{
		return $this->active_holiday_balance;
	}

	public function cancelledHolidayBalance()
	{
		return 0;
	}

	public function completedHolidayBalance()
	{
		return $this->completed_holiday_balance;
	}

	/**
	 * Is there an approved Holiday Request recorded for this user today
	 *
	 * @return bool
	 */
	public function onApprovedLeave()
	{
		return false;
	}

	/**
	 * Does this user have any approved holiday requests
	 * Utility to facilitate display logic
	 * x
	 * @return bool
	 */
	public function hasApprovedHoliday()
	{
		return $this->approvedHolidayBalance() > 0;
	}

	/**
	 * Validate a Holiday Request
	 *
	 * @throws Exception
	 * @return bool
	 */
	private function validateHolidayRequest()
	{
		switch (true) {
			// Does this user have any holiday allowance left
			case $this->availableHolidayAllowance() <= 0:
				throw new Exception('Your Holiday Request could not be placed. Your Annual Holiday Allowance has been taken');
				break;
			default:
				return true;
		}
	}

	/**
	 * Can this User manage Holiday Requests
	 * Generally they will be a Department Lead but this may be extended to allow Team Leads to deputise
	 * There is possibly a Super User that can approve Requests in the absence of relevant Department Lead
	 *
	 * @return bool
	 * @param Department $department
	 */
	public function hasManageHolidayRequestPermission(Department $department = null)
	{
		return $this->isSuperUser() || $this->isDepartmentLead($department);
	}

	/**
	 * Can this user view Team Holiday Summaries
	 *
	 * @throws Exception
	 * @return bool
	 * @param Department $department
	 */
	public function viewDepartmentHolidaySummary(Department $department)
	{
		if ( ! $this->hasManageHolidayRequestPermission($department)) {
			throw new Exception('Only Team Leads can view Holiday summaries');
		}

		$holiday_request = new HolidayRequest();

		return $holiday_request->getDepartmentSummary($department);
	}

}
