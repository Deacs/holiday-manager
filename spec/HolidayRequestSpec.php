<?php

namespace spec\App;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \App\User as User;
use \App\HolidayRequest as HolidayRequest;
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
        $this->status_id->shouldBe(HolidayRequest::PENDING_STATUS_ID);
    }

    function it_will_set_correct_status_id_after_set_status_id_approved_is_called()
    {
        $this->setStatusIdApproved();
        $this->status_id->shouldBe(HolidayRequest::APPROVED_STATUS_ID);
    }

    function it_will_set_correct_status_id_after_set_status_id_declined_is_called()
    {
        $this->setStatusIdDeclined();
        $this->status_id->shouldBe(HolidayRequest::DECLINED_STATUS_ID);
    }

    function it_will_set_correct_status_id_after_set_status_id_active_is_called()
    {
        $this->setStatusIdActive();
        $this->status_id->shouldBe(HolidayRequest::ACTIVE_STATUS_ID);
    }

    function it_will_set_correct_status_id_after_set_status_id_cancelled_is_called()
    {
        $this->setStatusIdCancelled();
        $this->status_id->shouldBe(HolidayRequest::CANCELLED_STATUS_ID);
    }

    function it_will_set_correct_status_id_after_set_status_id_completed_is_called()
    {
        $this->setStatusIdCompleted();
        $this->status_id->shouldBe(HolidayRequest::COMPLETED_STATUS_ID);
    }

    // -- Check correct status id has been set after transitions
    function it_will_set_the_appropriate_status_after_being_set_to_approved()
    {
        // Set the status to Pending so it will pass the approval validation
        $this->status_id = HolidayRequest::PENDING_STATUS_ID;
        $this->approve();
        $this->status_id->shouldBe(HolidayRequest::APPROVED_STATUS_ID);
    }

    function it_will_set_the_appropriate_status_after_being_set_to_declined()
    {
        // Set the status to Pending which will pass the decline validation
        $this->status_id = HolidayRequest::PENDING_STATUS_ID;
        $this->decline();
        $this->status_id->shouldBe(HolidayRequest::DECLINED_STATUS_ID);
    }

    function it_will_set_the_appropriate_status_after_being_set_to_cancelled()
    {
        // Set the status to Pending which will pass the cancellation validation
        $this->status_id = HolidayRequest::PENDING_STATUS_ID;
        $this->cancel();
        $this->status_id->shouldBe(HolidayRequest::CANCELLED_STATUS_ID);
    }

    // -- Manage transitions between status
    function it_will_be_prevented_from_being_approved_when_it_is_approved()
    {
        $this->status_id = HolidayRequest::APPROVED_STATUS_ID;
        $this->shouldThrow(new Exception('Holiday Request has already been approved'))->duringApprove();
    }

    function it_will_be_prevented_from_being_approved_when_it_has_been_declined()
    {
        $this->status_id = HolidayRequest::DECLINED_STATUS_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be approved, it has already been declined'))->duringApprove();
    }

    function it_will_be_prevented_from_being_approved_when_it_is_active()
    {
        $this->status_id = HolidayRequest::ACTIVE_STATUS_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be approved, it is currently active'))->duringApprove();
    }

    function it_will_be_prevented_from_being_approved_when_it_has_been_cancelled()
    {
        $this->status_id = HolidayRequest::CANCELLED_STATUS_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be approved, it has been cancelled'))->duringApprove();
    }

    function it_will_be_prevented_from_being_approved_when_it_has_been_completed()
    {
        $this->status_id = HolidayRequest::COMPLETED_STATUS_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be approved, it has already been completed'))->duringApprove();
    }

    function it_will_be_prevented_from_being_cancelled_when_it_has_been_declined()
    {
        $this->status_id = HolidayRequest::DECLINED_STATUS_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be cancelled, it has already been declined'))->duringCancel();
    }

    function it_will_be_prevented_from_being_cancelled_when_it_is_active()
    {
        $this->status_id = HolidayRequest::ACTIVE_STATUS_ID;
        $this->shouldThrow(new \Exception('Holiday Request cannot be cancelled, it is currently active'))->duringCancel();
    }

    function it_will_be_prevented_from_being_cancelled_when_it_has_been_cancelled()
    {
        $this->status_id = HolidayRequest::CANCELLED_STATUS_ID;
        $this->shouldThrow(new Exception('Holiday Request has already been cancelled'))->duringCancel();
    }

    function it_will_be_prevented_from_being_cancelled_when_it_has_been_completed()
    {
        $this->status_id = HolidayRequest::COMPLETED_STATUS_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be cancelled, it has already been completed'))->duringCancel();
    }

    function it_will_be_prevented_from_being_declined_when_it_is_declined()
    {
        $this->status_id = HolidayRequest::DECLINED_STATUS_ID;
        $this->shouldThrow(new Exception('Holiday Request has already been declined'))->duringDecline();
    }

    function it_will_be_prevented_from_being_declined_when_it_is_active()
    {
        $this->status_id = HolidayRequest::ACTIVE_STATUS_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be declined, it is currently active'))->duringDecline();
    }

    function it_will_be_prevented_from_being_declined_when_it_has_been_cancelled()
    {
        $this->status_id = HolidayRequest::CANCELLED_STATUS_ID;
        $this->shouldThrow(new Exception('Holiday Request cannot be declined, it has already been cancelled'))->duringDecline();
    }

    function it_will_be_prevented_from_being_declined_when_it_has_been_completed()
    {
        $this->status_id = HolidayRequest::COMPLETED_STATUS_ID;
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
}
