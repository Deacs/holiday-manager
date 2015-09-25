<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationTest extends CrowdcubeTester
{

    protected $baseUrl = 'http://caliente.dev';

    /**
     * @test
     */
    public function anonymous_users_are_redirected_to_login_when_requesting_location_route()
    {
        $this->visit('/locations/exeter')
            ->onPage('/login');
    }

    /**
     * @test
     */
    public function adding_new_location_results_in_correct_data_being_persisted()
    {
        $this->withoutMiddleware();

        $data =[
            'name'      => 'Test Office',
            'address'   => 'Test Rd, Test, Test TE1 4ST',
            'telephone' => '01803 123456',
            'lat'       => '50.4737288',
            'lon'       => '-3.5360752',
        ];

        $this->call('POST', '/locations/add', $data);

        $this->assertResponseStatus(302);

        $this->seeInDatabase('locations', $data);

        // A slug should have been automatically generated
        $this->seeInDatabase('locations', ['slug' => 'test-office']);
    }

    /**
     * @test
     */
    public function attempting_to_add_location_missing_required_fields_prevents_persistence()
    {
        $this->withoutMiddleware();

        $data =[
            'name'      => 'Test Office',
            'address'   => 'Test Rd, Test, Test TE1 4ST',
            'telephone' => '01803 123456',
        ];

        $this->call('POST', '/locations/add', $data);

        $this->assertResponseStatus(302);

        $this->getExpectedException('foo');

        $this->notSeeInDatabase('locations', ['name' => 'Test Office']);
    }

}
