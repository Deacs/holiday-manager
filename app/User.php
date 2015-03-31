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
		'password'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

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

	/**
	 * Check on the status of all holiday requests within business year
	 *
	 * @return bool
	 * @param $status_id
	 */
	public function checkHolidayRequests($status_id)
	{
		// Retrieve a collection of HolidayRequests (within current holiday year) with the provided status

		//$holiday_requests = HolidayRequest::where('user_id', $this->id)->where('status_id', $status_id)->get();
		//return $holiday_requests;

		return true;
	}

	/**
	 * Check balance of approved holiday requests
	 */
	public function checkApprovedHolidayBalance()
	{
		$this->checkHolidayRequests(2);
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
