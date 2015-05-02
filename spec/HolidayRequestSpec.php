<?php

namespace spec\App;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \App\User as User;
use \App\HolidayRequest as HolidayRequest;
use \App\Status as Status;
use \Exception as Exception;

class HolidayRequestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\HolidayRequest');
    }

    // -- Check correct status id has been set after setters
    function it_will_set_correct_status_id_after_set_status_id_pending_is_called()
    {
        $this->setStatusIdPending();
        $this->status_id->shouldBe(Status::PENDING_ID);
    }

    function it_will_set_correct_status_id_after_set_status_id_approved_is_called()
    {
        $this->setStatusIdApproved();
        $this->status_id->shouldBe(Status::APPROVED_ID);
    }

    function it_will_set_correct_status_id_after_set_status_id_declined_is_called()
    {
        $this->setStatusIdDeclined();
        $this->status_id->shouldBe(Status::DECLINED_ID);
    }

    function it_will_set_correct_status_id_after_set_status_id_active_is_called()
    {
        $this->setStatusIdActive();
        $this->status_id->shouldBe(Status::ACTIVE_ID);
    }

    function it_will_set_correct_status_id_after_set_status_id_cancelled_is_called()
    {
        $this->setStatusIdCancelled();
        $this->status_id->shouldBe(Status::CANCELLED_ID);
    }

    function it_will_set_correct_status_id_after_set_status_id_completed_is_called()
    {
        $this->setStatusIdCompleted();
        $this->status_id->shouldBe(Status::COMPLETED_ID);
    }

    // -- Check correct status id has been set after transitions
    function it_will_set_the_appropriate_status_after_being_set_to_approved()
    {
        $requesting_user    = new User();
        $approving_user     = new User();

        $requesting_user->id    = 1;
        $approving_user->lead   = 1;
        $approving_user->id     = 2;

        // Ensure the date validation passes
        $this->makeValidDate();

        $this->requestingUser($requesting_user);
        $this->approvingUser($approving_user);
        $this->approve();
        $this->status_id->shouldBe(Status::APPROVED_ID);
    }

    function it_will_set_the_appropriate_status_after_being_set_to_declined()
    {
        // Ensure the date validation passes
        $this->makeValidDate();

        $this->decline();
        $this->status_id->shouldBe(Status::DECLINED_ID);
    }

    function it_will_set_the_appropriate_status_after_being_set_to_cancelled()
    {
        $this->user_id          = 1;
        $requesting_user        = new User();
        $requesting_user->id    = 1;
        $this->requestingUser($requesting_user);

        // Ensure the date validation passes
        $this->makeValidDate();

        $this->cancel();
        $this->status_id->shouldBe(Status::CANCELLED_ID);
    }

    // -- Manage transitions between status
    function it_will_be_prevented_from_being_approved_when_it_is_approved()
    {
        $requesting_user    = new User();
        $approving_user     = new User();

        $requesting_user->id    = 1;
        $approving_user->lead   = 1;
        $approving_user->id     = 2;

        $this->requestingUser($requesting_user);
        $this->approvingUser($approving_user);
        $this->status_id = Status::APPROVED_ID;
        $this->shouldThrow(new Exception('Holiday Request has already been approved'))->duringApprove();
    }

    function it_will_be_prevented_from_being_approved_when_it_has_been_declined()
    {
        $requesting_user    = new User();
        $approving_user     = new User();

        $requesting_user->id    = 1;
        $approving_user->lead   = 1;
        $approving_user->id     = 2;

        $this->requestingUser($requesting_user);
        $this->approvingUser($approving_user);
        $this->status_id = Status::DECLINED_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be approved, it has already been declined'))->duringApprove();
    }

    function it_will_be_prevented_from_being_approved_when_it_is_active()
    {
        $requesting_user    = new User();
        $approving_user     = new User();

        $requesting_user->id    = 1;
        $approving_user->lead   = 1;
        $approving_user->id     = 2;

        $this->requestingUser($requesting_user);
        $this->approvingUser($approving_user);
        $this->status_id = Status::ACTIVE_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be approved, it is currently active'))->duringApprove();
    }

    function it_will_be_prevented_from_being_approved_when_it_has_been_cancelled()
    {
        $requesting_user    = new User();
        $approving_user     = new User();

        $requesting_user->id    = 1;
        $approving_user->lead   = 1;
        $approving_user->id     = 2;

        $this->requestingUser($requesting_user);
        $this->approvingUser($approving_user);
        $this->status_id = Status::CANCELLED_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be approved, it has been cancelled'))->duringApprove();
    }

    function it_will_be_prevented_from_being_approved_when_it_has_been_completed()
    {
        $requesting_user    = new User();
        $approving_user     = new User();

        $requesting_user->id    = 1;
        $approving_user->lead   = 1;
        $approving_user->id     = 2;

        $this->requestingUser($requesting_user);
        $this->approvingUser($approving_user);

        $this->status_id = Status::COMPLETED_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be approved, it has already been completed'))->duringApprove();
    }

    function it_will_be_prevented_from_being_cancelled_when_it_has_been_declined()
    {
        $this->user_id          = 1;
        $requesting_user        = new User();
        $requesting_user->id    = 1;
        $this->requestingUser($requesting_user);

        $this->status_id = Status::DECLINED_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be cancelled, it has already been declined'))->duringCancel();
    }

    function it_will_be_prevented_from_being_cancelled_when_it_is_active()
    {
        $this->user_id          = 1;
        $requesting_user        = new User();
        $requesting_user->id    = 1;
        $this->requestingUser($requesting_user);

        $this->status_id = Status::ACTIVE_ID;
        $this->shouldThrow(new \Exception('Holiday Request cannot be cancelled, it is currently active'))->duringCancel();
    }

    function it_will_be_prevented_from_being_cancelled_when_it_has_been_cancelled()
    {
        $this->user_id          = 1;
        $requesting_user        = new User();
        $requesting_user->id    = 1;
        $this->requestingUser($requesting_user);

        $this->status_id = Status::CANCELLED_ID;
        $this->shouldThrow(new Exception('Holiday Request has already been cancelled'))->duringCancel();
    }

    function it_will_be_prevented_from_being_cancelled_when_it_has_been_completed()
    {
        $this->user_id          = 1;
        $requesting_user        = new User();
        $requesting_user->id    = 1;
        $this->requestingUser($requesting_user);

        $this->status_id = Status::COMPLETED_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be cancelled, it has already been completed'))->duringCancel();
    }

    function it_will_be_prevented_from_being_declined_when_it_is_declined()
    {
        $this->status_id = Status::DECLINED_ID;
        $this->shouldThrow(new Exception('Holiday Request has already been declined'))->duringDecline();
    }

    function it_will_be_prevented_from_being_declined_when_it_is_active()
    {
        $this->status_id = Status::ACTIVE_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be declined, it is currently active'))->duringDecline();
    }

    function it_will_be_prevented_from_being_declined_when_it_has_been_cancelled()
    {
        $this->status_id = Status::CANCELLED_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be declined, it has already been cancelled'))->duringDecline();
    }

    function it_will_be_prevented_from_being_declined_when_it_has_been_completed()
    {
        $this->status_id = Status::COMPLETED_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be declined, it has already been completed'))->duringDecline();
    }

    function it_will_be_prevented_from_requesting_holiday_that_starts_in_the_past()
    {
        // Set the test day as a Monday to ensure the weekend validation passes
        $dt = new Carbon('this monday');
        $this->setDate($dt->subWeeks(2));

        $this->shouldThrow(new Exception('You cannot make a Holiday Request for a date in the past'))->duringPlace();
    }

    function it_will_be_prevented_from_requesting_holiday_outside_of_the_current_year()
    {
        $dt = Carbon::create();
        $this->setDate($dt->addYear());

        $this->shouldThrow(new \Exception('Holiday Requests can only be made for the current year'))->duringPlace();
    }

    function it_will_prevent_a_holiday_request_being_accepted_for_a_weekend()
    {
        // Set the test date to next Saturday to ensure the future date validation passes
        $dt = new Carbon('next saturday');
        $this->setDate($dt);

        $this->shouldThrow(new Exception('Requested date is a weekend'))->duringPlace();
    }

    function it_will_return_the_current_year_from_get_holiday_start_year_when_none_set()
    {
        $dt = new Carbon();

        $this->getHolidayStartYear()->shouldReturn($dt->year);
    }

    function it_will_return_2014_from_get_holiday_start_year_when_2014_has_been_set()
    {
        $this->setHolidayStartYear(2014);

        $this->getHolidayStartYear()->shouldReturn(2014);
    }

    function it_will_be_prevent_a_user_from_approving_their_own_holiday_request()
    {
        $requesting_user    = new User();
        $approving_user     = new User();

        $requesting_user->id    = 2;

        $approving_user->lead   = 1;
        $approving_user->id     = 2;

        $this->requestingUser($requesting_user);
        $this->approvingUser($approving_user);

        $this->shouldThrow(new Exception('You cannot approve your own Holiday Requests'))->duringApprove();
    }

    function it_will_prevent_non_department_leads_from_approving_holiday_requests()
    {
        $requesting_user    = new User();
        $approving_user     = new User();

        $requesting_user->id    = 1;
        $approving_user->lead   = 0;

        $this->requestingUser($requesting_user);
        $this->approvingUser($approving_user);

        $this->shouldThrow(new Exception('Only Department Leads can approve Holiday Requests'))->duringApprove();
    }

    function it_will_allow_department_lead_to_approve_holiday_for_own_department_members()
    {
        $requesting_user    = new User();
        $approving_user     = new User();

        $requesting_user->id            = 1;
        $requesting_user->department_id = 1;
        $approving_user->id             = 2;
        $approving_user->department_id  = 1;
        $approving_user->lead           = 1;

        // Ensure the date validation passes
        $this->makeValidDate();

        $this->requestingUser($requesting_user);
        $this->approvingUser($approving_user);

        $this->approve()->shouldReturn(true);
    }

    function it_will_return_false_when_checking_department_ids_for_requester_and_approver_when_they_do_not_match()
    {
        $requesting_user    = new User();
        $approving_user     = new User();

        $requesting_user->department_id = 1;
        $approving_user->department_id  = 2;

        $this->requestingUser($requesting_user);
        $this->approvingUser($approving_user);

        $this->approverMatchesRequesterDepartment()->shouldReturn(false);
    }

    function it_will_prevent_department_lead_from_approving_holiday_requests_for_members_of_another_team()
    {
        $requesting_user    = new User();
        $approving_user     = new User();

        $requesting_user->id            = 1;
        $approving_user->department_id  = 1;
        $approving_user->lead           = 1;

        $requesting_user->department_id = 2;

        $this->requestingUser($requesting_user);
        $this->approvingUser($approving_user);

        $this->shouldThrow(new Exception('You may only approve Holiday Requests from members of your own Department'))->duringApprove();
    }

    function it_will_allow_a_super_user_to_approve_holiday_for_members_of_another_team()
    {
        $requesting_user    = new User();
        $approving_user     = new User();

        $requesting_user->id            = 1;
        $requesting_user->department_id = 1;

        $approving_user->id             = 2;
        $approving_user->super_user     = 1;
        $approving_user->department_id  = 2;

        // Ensure the date validation passes
        $this->makeValidDate();

        $this->requestingUser($requesting_user);
        $this->approvingUser($approving_user);

        $this->approve()->shouldReturn(true);
    }

    function it_will_prevent_a_user_cancelling_requests_of_others()
    {
        $this->user_id          = 1;
        $this->status_id        = Status::PENDING_ID;
        $requesting_user        = new User();
        $requesting_user->id    = 2;
        $this->requestingUser($requesting_user);

        $this->shouldThrow(new Exception('You can only cancel your own Holiday Requests'))->duringCancel();
    }

    function it_returns_true_when_triggering_an_email_notification_on_successful_holiday_request_approval()
    {
        $requesting_user    = new User();
        $approving_user     = new User();

        $requesting_user->id    = 1;
        $approving_user->lead   = 1;
        $approving_user->id     = 2;

        // Ensure the date validation passes
        $this->makeValidDate();

        $this->requestingUser($requesting_user);
        $this->approvingUser($approving_user);

        $this->approve();
        $this->sendApprovalNotification()->shouldReturn(true);
    }

    // -- Utility Functions

    /**
     * Ensure the date set is valid
     * Date validation checks for a date in the future, that is not a weekend and is this year
     *
     * @return $this
     */
    private function makeValidDate()
    {
        // Ensure the weekend validation passes
        $dt = new Carbon('next friday');
        // Prevent validation failures when next Friday is actually the following year
        $dt->year((new Carbon())->year);

        $this->setDate($dt);

        return $this;
    }

}
