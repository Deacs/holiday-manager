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
    public function standard_user_attempting_to_view_add_location_screen_receives_unauthorised_response()
    {
        Auth::loginUsingId(2);

        $this->visit('/locations/add')
                ->see('Only Super Users are permitted to add new Locations');
    }

    /**
     * @test
     */
    public function non_super_user_attempting_to_add_new_location_receives_unauthorised_response()
    {
        Auth::loginUsingId(2);

        $this->withoutMiddleware();

        $this->post('/locations/add')
            ->assertResponseStatus(403);
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

}
