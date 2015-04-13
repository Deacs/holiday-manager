<?php

namespace spec\App;

use App\Department;
use Carbon\Carbon;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \App\HolidayRequest as HolidayRequest;
use \App\User as User;
use \App\Status as Status;
use \Exception as Exception;

class UserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\User');
    }

    function it_returns_a_correctly_formatted_full_name()
    {
        $this->first_name   = 'John';
        $this->last_name    = 'Smith';

        $this->fullName()->shouldReturn('John Smith');
    }

    function it_will_return_false_when_not_department_lead()
    {
        $this->lead = 0;

        $this->isDepartmentLead()->shouldReturn(false);
    }

    function it_will_return_true_when_department_lead()
    {
        $this->lead = 1;

        $this->isDepartmentLead()->shouldReturn(true);
    }

    function it_will_return_false_when_not_super_user()
    {
        $this->super_user = 0;

        $this->isSuperUser()->shouldReturn(false);
    }

    function it_will_return_true_when_super_user()
    {
        $this->super_user = 1;

        $this->isSuperUser()->shouldReturn(true);
    }

    function it_will_return_true_when_checking_has_manage_holiday_request_permission_for_department_lead()
    {
        $this->lead = 1;

        $this->hasManageHolidayRequestPermission()->shouldReturn(true);
    }

    function it_will_return_true_when_checking_has_manage_holiday_request_permission_for_super_user()
    {
        $this->super_user = 1;

        $this->hasManageHolidayRequestPermission()->shouldReturn(true);
    }

    function it_can_add_a_holiday_request()
    {
        $holiday_request = new HolidayRequest();
        $holiday_request->user_id = $this->id;
        $dt = new Carbon();
        // Set the current day to a weekday to satisfy the Weekday validation
        $dt = $dt->next(1);
        $holiday_request->setDate($dt->addWeek());

        $this->addHolidayRequest($holiday_request)->shouldReturn(true);
    }

    function it_can_cancel_a_pending_holiday_request()
    {
        $holiday_request = new HolidayRequest();
        $holiday_request->status_id = Status::PENDING_ID;

        $this->cancelHolidayRequest($holiday_request)->shouldReturn(true);
    }

    function it_can_cancel_an_approved_holiday_request()
    {
        $holiday_request = new HolidayRequest();
        $holiday_request->status_id = Status::APPROVED_ID;

        $this->cancelHolidayRequest($holiday_request)->shouldReturn(true);
    }

    function it_will_be_prevented_from_cancelling_holiday_requests_made_by_others(HolidayRequest $holiday_request)
    {
        $holiday_request->user_id = 1;
        $this->id = 2;

        $this->shouldThrow(new Exception('You can only cancel your own Holiday Requests'))->duringCancelHolidayRequest($holiday_request);
    }

    function it_is_department_lead_but_will_be_prevented_from_approving_holiday_for_members_of_another_team()
    {
        $requesting_user = new User();
        $holiday_request = new HolidayRequest();

        $requesting_user->id            = 1;
        $requesting_user->department_id = 1;
        $holiday_request->requester($requesting_user);

        $this->id                       = 2;
        $this->lead                     = 1;
        $this->department_id            = 2;

        $this->shouldThrow(new Exception('You may only approve Holiday Requests from members of your own Department'))->duringApproveTeamHolidayRequest($holiday_request);
    }

    function it_is_a_super_user_and_will_be_allowed_to_approve_holiday_for_members_of_another_team()
    {
        $requesting_user = new User();
        $holiday_request = new HolidayRequest();

        $requesting_user->id            = 1;
        $requesting_user->department_id = 1;
        $holiday_request->requester($requesting_user);

        $this->id                       = 2;
        $this->super_user               = 1;
        $this->department_id            = 1;

        $this->approveTeamHolidayRequest($holiday_request)->shouldReturn(true);
    }

    function it_is_department_lead_and_can_approve_holiday_for_own_department_members()
    {
        $requesting_user = new User();
        $holiday_request = new HolidayRequest();

        $requesting_user->id        = 2;
        $holiday_request->requester($requesting_user);
        $this->id                   = 1;
        $this->lead                 = 1;

        $this->approveTeamHolidayRequest($holiday_request)->shouldReturn(true);
    }

    function it_will_be_prevented_from_approving_holiday_requests_if_not_department_lead(HolidayRequest $holiday_request)
    {
        $this->lead = 0;
        $this->shouldThrow(new Exception('Only Department Leads can approve Holiday Requests'))->duringApproveTeamHolidayRequest($holiday_request);
    }

    function it_will_be_prevented_from_approving_own_holiday_request()
    {
        $requesting_user = new User();
        $holiday_request = new HolidayRequest();

        $requesting_user->id        = 2;
        $holiday_request->requester($requesting_user);

        $this->lead                 = 1;
        $this->id                   = 2;

        $this->shouldThrow(new Exception('You cannot approve your own Holiday Requests'))->duringApproveTeamHolidayRequest($holiday_request);
    }

    function it_can_see_a_full_allowance_of_available_holiday_when_no_holiday_has_been_requested_taken_or_active()
    {
        $this->availableHolidayAllowance()->shouldReturn(25);
    }

    function it_can_see_an_allowance_of_22_available_holiday_days_when_3_days_holiday_have_been_approved()
    {
        $this->approved_holiday_balance = 3;
        $this->availableHolidayAllowance()->shouldReturn(22);
    }

    function it_can_see_an_allowance_of_10_available_holiday_days_when_15_are_complete()
    {
        $this->completed_holiday_balance = 15;
        $this->availableHolidayAllowance()->shouldReturn(10);
    }

    function it_can_see_an_allowance_of_12_available_holiday_days_when_2_are_active_5_are_complete_3_are_pending_and_3_are_approved()
    {
        $this->active_holiday_balance       = 2;
        $this->completed_holiday_balance    = 5;
        $this->pending_holiday_balance      = 3;
        $this->approved_holiday_balance     = 3;

        $this->availableHolidayAllowance()->shouldReturn(12);
    }

    function it_will_prevent_holiday_from_being_requested_when_pending_requests_complete_allowance(HolidayRequest $holiday_request)
    {
        $this->completed_holiday_balance    = 20;
        $this->pending_holiday_balance      = 5;

        $this->shouldThrow(new Exception('Your Holiday Request could not be placed. Your Annual Holiday Allowance has been taken'))->duringAddHolidayRequest($holiday_request);
    }

    function it_will_return_an_array_of_values_for_each_balance_of_holiday_status()
    {
        $active     = 2;
        $completed  = 5;
        $pending    = 3;
        $approved   = 3;

        $this->active_holiday_balance       = $active;
        $this->completed_holiday_balance    = $completed;
        $this->pending_holiday_balance      = $pending;
        $this->approved_holiday_balance     = $approved;

        $this->getHolidayBalanceSummary()->shouldReturn([
            'Annual Allowance'  => 25,
            'Completed Holiday' => $completed,
            'Active Holiday'    => $active,
            'Pending Requests'  => $pending,
            'Approved Requests' => $approved,
            'Available Balance' => 12
        ]);
    }

    function it_will_return_holiday_summary_for_department_if_team_lead(Department $department)
    {
        $this->lead = 1;

        $this->viewDepartmentHolidaySummary($department)->shouldReturn([]);
    }

    function it_will_be_prevented_from_viewing_team_holiday_summary_if_not_team_lead(Department $department)
    {
        $this->lead = 0;

        $this->shouldThrow(new Exception('Only Team Leads can view Holiday summaries'))->duringViewDepartmentHolidaySummary($department);
    }

    function it_is_notified_by_email_when_holiday_request_is_approved(HolidayRequest $holiday_request)
    {
        $holiday_request->approve();
        //$holiday_request->sendApprovalNotification($this)->shouldBeCalled();
        //$holiday_request->sendApprovalNotification()->shouldBeCalled();
    }
}
