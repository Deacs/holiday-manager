<?php  namespace App;

/**
 * This class represents an individual holiday request
 * It is important to note that a request of 5 successive days will be stored as 5 individual requests
 * This allows individual days of a block request to be approved or declined independently
 * without the user having to re-submit the entire request
 */

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon as Carbon;
use \Exception as Exception;

class HolidayRequest extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'holiday_requests';

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'status_id',
        'approved_by',
        'declined_by'
    ];

    public $requesting_user;
    public $approving_user;

    // The date of the requested holiday
    public $request_date;
    public $holiday_start_date_year;
    public $holiday_end_date_year;
    public $holiday_start_date;
    public $holiday_end_date;

    public $approved_by;
    public $declined_by;

    // The default status for a request is Pending
//    public $status_id = Status::PENDING_ID;

    /**
     * Specify the start date for the request
     *
     * @param $start_date
     */
    public function setStartDate($start_date)
    {
        $this->start_date = Carbon::createFromFormat('Y-m-d', $start_date);
    }

    /**
     * Specify the end date for the request
     *
     * @param $end_date
     */
    public function setEndDate($end_date)
    {
        $this->end_date = Carbon::createFromFormat('Y-m-d', $end_date);
    }

    /**
     * Return the starting date - this will be a formatted Carbon instance
     *
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Return the ending date - this will be a formatted Carbon instance
     *
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    // -- Relationships
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function approver()
    {
        return $this->hasOne('App\User', 'id', 'approved_by');
    }

    public function decliner()
    {
        return $this->hasOne('App\User', 'id', 'declined_by');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function requestingUser(User $requesting_user)
    {
        $this->requesting_user = $requesting_user;
    }

    public function approvingUser(User $approving_user)
    {
        $this->approving_user = $approving_user;
    }

    /**
     * Set the starting Year of the Holiday Requests we are dealing with
     *
     * @param $holiday_start_date_year
     */
    public function setHolidayStartYear($holiday_start_date_year)
    {
        $this->holiday_start_date_year = $holiday_start_date_year;
    }

    /**
     * Set the starting Year of the Holiday Requests we are dealing with
     *
     * @param $holiday_end_date_year
     */
    public function setHolidayEndYear($holiday_end_date_year)
    {
        $this->holiday_end_date_year = $holiday_end_date_year;
    }

    // -- Setters to protect the usage of class constants for Status IDs
    /**
     * Set the status ID to pending
     */
    public function setStatusIdPending()
    {
        $this->status_id = Status::PENDING_ID;
    }

    /**
     * Set the status ID to approved
     */
    public function setStatusIdApproved()
    {
        $this->status_id = Status::APPROVED_ID;
    }

    /**
     * Set the status ID to declined
     */
    public function setStatusIdDeclined()
    {
        $this->status_id = Status::DECLINED_ID;
    }

    /**
     * Set the status ID to active
     */
    public function setStatusIdActive()
    {
        $this->status_id = Status::ACTIVE_ID;
    }

    /**
     * Set the status ID to cancelled
     */
    public function setStatusIdCancelled()
    {
        $this->status_id = Status::CANCELLED_ID;
    }

    /**
     * Set the status ID to completed
     */
    public function setStatusIdCompleted()
    {
        $this->status_id = Status::COMPLETED_ID;
    }

    /**
     * Return the start year of the holiday requests we are concerned with
     * If nothing has been specified, we presume we are dealing with the current year
     *
     * @return int
     */
    public function getHolidayStartYear()
    {
        if ( ! empty($this->holiday_start_date_year)) {
            return $this->holiday_start_date_year;
        }

        return (new Carbon())->year;
    }

    /**
     * Is this request pending
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status_id == Status::PENDING_ID;
    }

    /**
     * Has this request been approved
     *
     * @return bool
     */
    public function isApproved()
    {
        return $this->status_id == Status::APPROVED_ID;
    }

    /**
     * Has this request been declined
     *
     * @return bool
     */
    public function isDeclined()
    {
        return $this->status_id == Status::DECLINED_ID;
    }

    /**
     * Is this request currently active - i.e. the user is taking this holiday
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status_id == Status::ACTIVE_ID;
    }

    /**
     * Has this request been cancelled
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status_id == Status::CANCELLED_ID;
    }

    /**
     * Has this request completed i.e. an approved holiday request is in the past and has been taken
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status_id == Status::COMPLETED_ID;
    }

    /**
     * Attempt to record the request
     *
     * @throws Exception
     * @return bool
     */
    public function place()
    {
        return $this->save();

        if ($this->validateDate()) {
            return $this->save();
        }
    }

    /**
     * Validate the requested date
     *
     * @throws Exception
     * @return bool
     * @param $request_date
     */
    public function validateDate($request_date)
    {
        switch (true) {
            // The requested date cannot be in the past
            case $request_date->isPast():
                throw new Exception('You cannot make a Holiday Request for a date in the past');
                break;
            // The requested date must be within the current year
            case (new Carbon())->year != $request_date->year:
                throw new Exception('Holiday Requests can only be made for the current year');
                break;
            // The requested date ia a weekend
            case $request_date->isWeekend():
                throw new Exception('Requested date is a weekend');
                break;
            default:
                return true;
        }
    }

    /**
     * Approve a holiday request
     *
     * @return bool
     */
    public function approve()
    {
        if ($this->canBeApproved()) {

            $this->validateUserApproveAction();

            $this->status_id = Status::APPROVED_ID;
            $this->place();
            $this->sendApprovalNotification();

            return true;
        }

        return false;
    }
    /**
     * Cancel an existing Holiday Request
     *
     * @return bool
     */
    public function cancel()
    {
        if ($this->canBeCancelled()) {

            $this->validateUserCancelAction();

            $this->status_id = Status::CANCELLED_ID;
            $this->save();
            $this->sendCancellationNotification();

            return true;
        }

        return false;
    }

    /**
     * Decline a holiday request
     *
     * @return bool
     */
    public function decline()
    {
        if ($this->canBeDeclined()) {

            $this->validateUserDeclineAction();

            $this->status_id = Status::DECLINED_ID;
            $this->save();
            $this->sendDeclineNotification();

            return true;
        }

        return false;
    }

    /**
     * Validate that the user can approve requests
     *
     * @throws Exception
     * @return bool
     */
    private function validateUserApproveAction()
    {

        if ( ! $this->approving_user->isSuperUser() && ! $this->approverMatchesRequesterDepartment()) {
            throw new Exception('You may only approve Holiday Requests from members of your own Department');
        }

        if ( ! $this->approving_user->hasManageHolidayRequestPermission($this->requesting_user->department)) {
            throw new Exception('Only Department Leads can approve Holiday Requests');
        }

        if ($this->approving_user->id == $this->requesting_user->id) {
            throw new Exception('You cannot approve your own Holiday Requests');
        }

        return true;
    }

    /**
     * Validate that the user can cancel requests
     *
     * @throws Exception
     * @return bool
     */
    private function validateUserCancelAction()
    {
        if ($this->requesting_user->id != $this->user_id) {
            throw new Exception('You can only cancel your own Holiday Requests');
        }

        return true;
    }

    /**
     * Validate that the user can decline requests
     *
     * @throws Exception
     * @return bool
     */
    private function validateUserDeclineAction()
    {
        if ( ! $this->approving_user->hasManageHolidayRequestPermission($this->requesting_user->department)) {
            throw new Exception('Only Department Leads can decline Holiday Requests');
        }

        if ( ! $this->approving_user->isSuperUser() && ! $this->approverMatchesRequesterDepartment()) {
            throw new Exception('You may only decline Holiday Requests from members of your own Department');
        }

        return true;
    }

    /**
     * Can this request be approved
     *
     * @throws Exception
     * @return bool
     */
    private function canBeApproved()
    {
        // There are only certain states that allow approval
        if ($this->isPending()) {
            return true;
        }

        // If the request is not in an allowable state, throw the appropriate exception
        $this->explainApprovalRefusal();
    }

    /**
     * Can this request be cancelled
     *
     * @throws Exception
     * @return bool
     */
    private function canBeCancelled()
    {
        // There are only certain states that allow cancellation
        if ($this->isPending() || $this->isApproved()) {
            return true;
        }

        // If the request is not in an allowable state, throw the appropriate exception
        $this->explainCancellationRefusal();
    }

    /**
     * Can this request be declined
     *
     * @throws Exception
     * @return bool
     */
    private function canBeDeclined()
    {
        // There are only certain states that allow a request to be declined
        if ($this->isPending() || $this->isApproved()) {
            return true;
        }

        // If the request is not in an allowable state, throw the appropriate exception
        $this->explainDeclineRefusal();
    }

    /**
     * Explain why changing to approved status was refused
     *
     * @throws Exception
     * @return bool
     */
    private function explainApprovalRefusal()
    {
        switch (true) {
            case $this->isApproved():
                throw new \Exception('Holiday Request has already been approved');
                break;
            case $this->isDeclined():
                throw new \Exception('Holiday Request cannot be approved, it has already been declined');
                break;
            case $this->isActive():
                throw new \Exception('Holiday Request cannot be approved, it is currently active');
                break;
            case $this->isCancelled():
                throw new \Exception('Holiday Request cannot be approved, it has been cancelled');
                break;
            case $this->isCompleted():
                throw new \Exception('Holiday Request cannot be approved, it has already been completed');
                break;
            default:
                return true;
        }
    }

    /**
     * Explain why moving to cancelled status was refused
     *
     * @throws Exception
     * @return bool
     */
    private function explainCancellationRefusal()
    {
        switch (true) {
            case $this->isDeclined():
                throw new \Exception('Holiday Request cannot be cancelled, it has already been declined');
                break;
            case $this->isActive():
                throw new \Exception('Holiday Request cannot be cancelled, it is currently active');
                break;
            case $this->isCancelled():
                throw new \Exception('Holiday Request has already been cancelled');
                break;
            case $this->isCompleted():
                throw new \Exception('Holiday Request cannot be cancelled, it has already been completed');
                break;
            default:
                return true;
        }
    }

    /**
     * Explain why moving to declined status was refused
     *
     * @throws Exception
     * @return bool
     */
    private function explainDeclineRefusal()
    {
        switch (true) {
            case $this->isDeclined():
                throw new \Exception('Holiday Request has already been declined');
                break;
            case $this->isActive():
                throw new \Exception('Holiday Request cannot be declined, it is currently active');
                break;
            case $this->isCancelled():
                throw new \Exception('Holiday Request cannot be declined, it has already been cancelled');
                break;
            case $this->isCompleted():
                throw new \Exception('Holiday Request cannot be declined, it has already been completed');
                break;
            default:
                return true;
        }
    }

    // -- Send notifications
    /**
     * Send an approved notification
     *
     * @return bool
     */
    public function sendApprovalNotification()
    {
        return true;
    }

    /**
     * Send an declined notification
     *
     * @return bool
     */
    public function sendDeclineNotification()
    {
        return true;
    }

    /**
     * Send a successful cancellation notification
     *
     * @return bool
     */
    public function sendCancellationNotification()
    {
        return true;
    }

    /**
     * Ensure the user attempting to approve this request has suitable permissions
     * - Only Department Leads (or Super Users) can approve Requests
     * - Users cannot approve their own Requests - regardless of their 'Lead' status
     *
     * @throws Exception
     * @return bool
     */
    private function canApproveHolidayRequests()
    {
        if ( ! $this->hasManageHolidayRequestPermission($this->requesting_user->department)) {
            throw new Exception('Only Department Leads can approve Holiday Requests');
        }

        if ($this->approving_user->id == $this->requesting_user->id) {
            throw new Exception('You cannot approve your own Holiday Requests');
        }

        if ( ! $this->approverMatchesRequesterDepartment()) {
            throw new Exception('You may only approve Holiday Requests from members of your own Department');
        }

        return true;
    }

    /**
     * Approving users must belong to the same Department as the requesting user
     *
     * @return bool
     */
    public function approverMatchesRequesterDepartment()
    {
        return $this->approving_user->department_id == $this->requesting_user->department_id;
    }

    /**
     * Return a summary of Requests for the specified Team
     *
     * @return array
     * @param Department $department
     */
    public function getDepartmentSummary($department)
    {
        // @TODO Return a multi-dimensional array for each Team member
        $summary = [];

        // Each member will hold an array of each status and their values
        if ( ! empty($department->members)) {
            foreach ($department->members as $member) {
                $summary[$member->fullName()] = [];
            }
        }

        return $summary;
    }

}
