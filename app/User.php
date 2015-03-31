<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

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
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'telephone',
		'department_id',
		'password',
		'annual_holiday_allowance'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public $default_annual_holiday_alowance = 25;
	public $active_holiday_balance 			= 0;
	public $pending_holiday_balance 		= 0;
	public $approved_holiday_balance 		= 0;
	public $completed_holiday_balance 		= 0;
	public $available_holiday_balance 		= 0;
	public $unavailable_holiday_balance 	= 0;

	private function isDepartmentLead()
	{
		return $this->lead;
	}

	/**
	 * Place the holiday Request
	 *
	 * @return bool
	 * @param HolidayRequest $holiday_request
	 */
	public function addHolidayRequest(HolidayRequest $holiday_request)
	{
		return $holiday_request->place();
	}

	/**
	 * Cancel an existing holiday request
	 *
	 * @throws \Exception
	 * @return bool
	 * @param HolidayRequest $holiday_request
	 */
	public function cancelHolidayRequest(HolidayRequest $holiday_request)
	{
		if ($this->id !== $holiday_request->user_id) {
			throw new \Exception('You can only cancel your own Holiday Requests');
		}

		return $holiday_request->cancel();
	}

	public function getAnnualHolidayAllowance()
	{
		if ( ! empty($this->annual_holiday_allowance))
		{
			return $this->annual_holiday_allowance;
		}

		return $this->default_annual_holiday_alowance;
	}

	/**
	 * How many days holiday are already accounted for
	 * This will be the annual allowance minus active, approved, pending and completed requests
	 *
	 * @return mixed
	 */
	public function unavailableHolidayBalance()
	{
		return ($this->pendingBalance() + $this->approvedBalance() + $this->activeBalance() + $this->completedBalance());
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

	public function pendingBalance()
	{
		// Ensure that returned requests are for the current year
		return 0;
	}

	public function approvedBalance()
	{
		return $this->approved_holiday_balance;
	}

	public function declinedBalance()
	{
		return 0;
	}

	public function activeBalance()
	{
		return 0;
	}

	public function cancelledBalance()
	{
		return 0;
	}

	public function completedBalance()
	{
		return 0;
	}

	/**
	 * Check balance of approved holiday requests
	 */
	public function checkApprovedHolidayBalance()
	{
		return $this->approvedBalance();
	}

	/**
	 * Approve requested holiday for a team member
	 * This action is only allowable by a user flagged as lead for the department
	 * the requesting user is a member of
	 *
	 * @throws \Exception
	 * @param HolidayRequest $holiday_request
	 */
	public function approveTeamHolidayRequest(HolidayRequest $holiday_request)
	{
		if ($this->canApproveHolidayRequests($holiday_request)) {
			$holiday_request->approve();
		}
	}

	/**
	 * Ensure the user is able to approve Holiday Requests
	 * - Only Department Leads can approve Requests
	 * - Users cannot approve their own Requests - regardless of their 'Lead' status
	 *
	 * @throws \Exception
	 * @return bool
	 * @param HolidayRequest $holiday_request
	 */
	private function canApproveHolidayRequests(HolidayRequest $holiday_request)
	{
		if ( ! $this->isDepartmentLead()) {
			throw new \Exception('Only Department Leads can approve Holiday Requests');
		}

		if ($this->id == $holiday_request->user_id) {
			throw new \Exception('You cannot approve your own Holiday Requests');
		}

		if ($this->department_id != $holiday_request->user->department_id) {
			throw new \Exception('You may only approve Holiday Requests from members of your own Department');
		}

		return true;
	}

}
