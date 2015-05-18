<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use \Exception as Exception;
use \App\HolidayRequest as HolidayRequest;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

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
		'email',
		'password',
		'telephone',
		'department_id',
		'location_id',
		'lead',
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

	public $lead 							= false;
	public $super_user 						= false;


	// Relationships
	public function department()
	{
		return $this->belongsTo('App\Department', 'id', 'department_id');
	}

	public function location()
	{
		return $this->belongsTo('App\Location', 'id', 'location_id');
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
