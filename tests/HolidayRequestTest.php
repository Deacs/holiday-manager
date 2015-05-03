<?php

// https://laracasts.com/lessons/whats-new-in-testdummy

use Laracasts\TestDummy\Factory;
use Laracasts\TestDummy\DbTestCase;
use App\Repositories\HolidayRepository;

class HolidayRequestTest extends DbTestCase {

    public function setUp()
    {
        parent::setUp();

        $this->repository = new HolidayRepository;
    }

    public function test_return_requests_by_user_id_returns_correct_rows()
    {
        $user = Factory::create('App\User');
        // Holiday Requests for the newly created User
        Factory::times(2)->create('App\HolidayRequest', ['user_id' => $user->id]);
        // Scaffold some extra Requests that are not linked to the newly created User
        Factory::times(3)->create('App\HolidayRequest');

        $requests = $this->repository->getRequestsByUserId($user->id);

        $this->assertCount(2, $requests);
    }

    public function test_return_requests_by_status_id_returns_correct_rows()
    {
        $status = Factory::create('App\Status');
        Factory::times(4)->create('App\HolidayRequest', ['status_id' => $status->id]);
        Factory::times(6)->create('App\HolidayRequest');

        $requests = $this->repository->getRequestsByStatusId($status->id);

        $this->assertCount(4, $requests);
    }

}
