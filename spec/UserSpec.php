<?php

namespace spec\App;

use Carbon\Carbon;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \App\HolidayRequest as HolidayRequest;

class UserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\User');
    }

    function it_can_add_a_holiday_request()
    {
        $holiday_request = new \App\HolidayRequest();
        $holiday_request->user_id = $this->id;
        $dt = new Carbon();
        $holiday_request->setDate($dt->addWeek());

        $this->addHolidayRequest($holiday_request)->shouldReturn(true);
    }

    function it_can_cancel_a_requested_holiday_request(HolidayRequest $holiday_request)
    {
        $this->cancelHolidayRequest($holiday_request);

        $holiday_request->cancel()->shouldBeCalled();
    }

    function it_can_cancel_an_approved_holiday_request(HolidayRequest $holiday_request)
    {
        $this->cancelHolidayRequest($holiday_request);

        $holiday_request->cancel()->shouldBeCalled();
    }

    function it_will_be_prevented_from_cancelling_holiday_requests_made_by_others(HolidayRequest $holiday_request)
    {
        $holiday_request->user_id = 1;
        $this->id = 2;

        $this->shouldThrow(new \Exception('You can only cancel your own Holiday Requests'))->duringCancelHolidayRequest($holiday_request);
    }

    function it_is_department_lead_but_will_be_prevented_from_approving_holiday_for_members_of_another_team()
    {
        $requesting_user = new \App\user();
        $holiday_request = new \App\HolidayRequest();

        $requesting_user->department_id = 1;
        $requesting_user->id            = 1;
        $holiday_request->user          = $requesting_user;

        $this->id                       = 2;
        $this->lead                     = 1;
        $this->department_id            = 2;

        $this->shouldThrow(new \Exception('You may only approve Holiday Requests from members of your own Department'))->duringApproveTeamHolidayRequest($holiday_request);
    }

    function it_is_department_lead_and_can_approve_holiday_for_own_department_members()
    {
        $requesting_user = new \App\user();
        $holiday_request = new \App\HolidayRequest();

        $holiday_request->user      = $requesting_user;
        $this->id                   = 1;
        $this->lead                 = 1;

        $holiday_request->user_id   = 2;
        $this->approveTeamHolidayRequest($holiday_request);

        $this->shouldNotThrow(new \Exception('You may only approve Holiday Requests from members of your own Department'))->duringApproveTeamHolidayRequest($holiday_request);
    }

    function it_will_be_prevented_from_approving_holiday_requests_if_not_department_lead(HolidayRequest $holiday_request)
    {
        $this->lead = 0;
        $this->shouldThrow(new \Exception('Only Department Leads can approve Holiday Requests'))->duringApproveTeamHolidayRequest($holiday_request);

    }

    function it_will_be_prevented_from_approving_own_holiday_request()
    {
        $holiday_request = new \App\HolidayRequest();

        $this->lead                 = 1;
        $this->id                   = 2;
        $holiday_request->user_id   = 2;

        $this->shouldThrow(new \Exception('You cannot approve your own Holiday Requests'))->duringApproveTeamHolidayRequest($holiday_request);
    }

    function it_can_check_approved_holiday_balance()
    {
        $this->checkApprovedHolidayBalance();

//        $this->checkHolidayRequests(2)->shouldBeCalled();
    }

    function it_is_notified_by_email_when_holiday_request_is_approved(HolidayRequest $holiday_request)
    {
        $holiday_request->approve();
//        $holiday_request->sendApprovalNotification()->shouldBeCalled();
    }
}
