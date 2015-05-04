<?php

// https://laracasts.com/lessons/whats-new-in-testdummy

use Laracasts\TestDummy\Factory;
use Laracasts\TestDummy\DbTestCase;
use \Carbon\Carbon as Carbon;
use App\Repositories\HolidayRepository;
use App\Status as Status;

class HolidayRequestTest extends DbTestCase {

    protected $repository;

    public function setUp()
    {
        parent::setUp();

        $this->repository = new HolidayRepository;
    }

    // -- Check correct status id has been set after transitions
    function test_the_appropriate_status_is_set_after_being_set_to_approved()
    {
        $department         = Factory::create('App\Department', ['id' => 1]);
        $requesting_user    = Factory::create('App\User', ['department_id' => $department->id]);
        $approving_user     = Factory::create('App\User', ['department_id' => $department->id, 'lead' => 1]);
        $holiday_request    = Factory::create('App\HolidayRequest', ['request_date' => $this->makeValidDate(), 'status_id' => Status::PENDING_ID]);

//        $requesting_user->id    = 1;
//        $approving_user->lead   = 1;
//        $approving_user->id     = 2;

        // Ensure the date validation passes
//        $this->makeValidDate();
//
//        $this->requestingUser($requesting_user);
//        $this->approvingUser($approving_user);
//        $this->approve();
//        $this->status_id->shouldBe(Status::APPROVED_ID);
    }

    public function test_get_requests_by_user_id()
    {
        $user = Factory::create('App\User');
        // Holiday Requests for the newly created User
        Factory::times(2)->create('App\HolidayRequest', ['user_id' => $user->id]);
        // Scaffold some extra Requests that are not linked to the newly created User
        Factory::times(3)->create('App\HolidayRequest');

        $requests = $this->repository->getRequestsByUserId($user->id);
        // Sanity check - did all scaffolded records make it to the DB
        $this->assertCount(5, $this->repository->getAllRequests());
        $this->assertCount(2, $requests);
    }

    public function test_get_requests_by_status_id()
    {
        $status = Factory::create('App\Status');
        Factory::times(4)->create('App\HolidayRequest', ['status_id' => $status->id]);
        Factory::times(6)->create('App\HolidayRequest');

        $requests = $this->repository->getRequestsByStatusId($status->id);
        // Sanity check - did all scaffolded records make it to the DB
        $this->assertCount(10, $this->repository->getAllRequests());
        $this->assertCount(4, $requests);
    }

    public function test_get_requests_approved_by_user_id()
    {
        $user = Factory::create('App\User', ['lead' => 1]);
        $status = Factory::create('App\Status', ['id' => \App\Status::APPROVED_ID]);
        Factory::times(4)->create('App\HolidayRequest', ['approved_by' => $user->id, 'status_id' => $status->id]);
        Factory::times(5)->create('App\HolidayRequest');

        $requests = $this->repository->getRequestsApprovedByUserId($user->id);
        // Sanity check - did all scaffolded records make it to the DB
        $this->assertCount(9, $this->repository->getAllRequests());
        $this->assertCount(4, $requests);
    }

    public function test_get_requests_by_department_id()
    {
        $department = Factory::create('App\Department', ['id' => 1]);
        $user_1 = Factory::create('App\User', ['department_id' => $department->id]);
        $user_2 = Factory::create('App\User', ['department_id' => $department->id]);
        Factory::times(3)->create('App\HolidayRequest', ['user_id' => $user_1->id]);
        Factory::times(1)->create('App\HolidayRequest', ['user_id' => $user_2->id]);
        Factory::times(3)->create('App\HolidayRequest');

        $requests = $this->repository->getRequestsByDepartmentId($department->id);
        // Sanity check - did all scaffolded records make it to the DB
        $this->assertCount(7, $this->repository->getAllRequests());
        $this->assertCount(4, $requests);
    }

    public function test_get_requests_for_specified_year()
    {
        $dt_1 = (new Carbon)->today();
        $dt_2 = (new Carbon)->subYear();

        Factory::times(3)->create('App\HolidayRequest', ['request_date' => $dt_1]);
        Factory::times(2)->create('App\HolidayRequest', ['request_date' => $dt_2]);

        $requests = $this->repository->getRequestsInSpecifiedYear($dt_1->year);
        // Sanity check - did all scaffolded records make it to the DB
        $this->assertCount(5, $this->repository->getAllRequests());
        $this->assertCount(3, $requests);
    }

//    public function test_valid_request_saves()
//    {
//        $user = Factory::create('App\User');
//        // Set the date for following year
//        $dt = (new Carbon)->addYear();
//        $holiday_request = Factory::create('App\HolidayRequest');
//
//        $holiday_request->setRequestDate((new Carbon)->addYear());
//
//        // Validation should reject the Request
//        $user->addHolidayRequest($holiday_request);
//
//        // There should be no record in the DB
//        $this->assertCount(5, $this->repository->getAllRequests());
//    }

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

        return $dt;
    }

}
