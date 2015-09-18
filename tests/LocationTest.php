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
    public function request_to_show_location_returns_correct_data()
    {
        Auth::loginUsingId(1);

        $this->get('/api/locations/exeter')->seeJsonContains([
            'name'      => 'Exeter',
            'slug'      => 'exeter',
            'address'   => 'Innovation Centre, Rennes Drive, Exeter, EX4 4RN',
            'telephone' => '01392 241319',
            'lat'       => '50.7381',
            'lon'       => '-3.53062',
        ]);
    }

    /**
     * @test
     */
    public function request_to_show_all_locations_returns_correct_location_names()
    {
        Auth::loginUsingid(1);

        $this->get('/api/locations')->seeJsonContains([
            'name' => 'Exeter',
            'name' => 'London',
            'name' => 'Manchester',
            'name' => 'Barcelona',
        ]);
    }

    /**
     * @test
     */
    public function adding_new_location_results_in_correct_data_being_persisted()
    {
        Auth::loginUsingId(15);

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
        Auth::loginUsingId(15);

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

    /**
     * @test
     */
//    public function missing_data_should_throw_exception_and_prevent_record_being_persisted()
//    {
//        $this->
//    }
}
