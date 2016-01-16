<?php

use App\User;
use App\Location;
use App\Department;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationTest extends CrowdcubeTester
{

    use DatabaseTransactions;

    protected $baseUrl = 'http://caliente.dev';

    /**
     * @test
     * @group location
     * @group permissions
     */
    public function anonymous_users_are_redirected_to_login_when_requesting_location_route()
    {
        $location = factory(Location::class)->create();

        $this->visit($location->url)
            ->seePageIs('/login');
    }

    /**
     * @test
     * @group location
     * @group permissions
     */
    public function non_super_user_attempting_to_view_add_location_screen_is_redirected_to_login()
    {
        $this->createUserAndLogin();

        $this->visit('/locations/add')
                ->seePageIs('/login');
    }

    /**
     * @test
     * @group location
     * @group permissions
     */
    public function non_super_user_attempting_to_add_new_location_receives_unauthorised_response()
    {
        $this->createUserAndLogin();

        $this->withoutMiddleware();

        $this->post('/locations/add')
                ->assertResponseStatus(403);
    }

    /**
     * @test
     * @group location
     * @group persistence
     */
    public function super_user_adding_new_location_results_in_correct_data_being_persisted()
    {
        $this->createUserAndLogin(1);

        $this->withoutMiddleware();

        $data = [
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
     * @group location
     * @group validation
     */
    public function attempting_to_add_location_missing_required_fields_prevents_persistence()
    {
        $user = $this->createSuperUser();

        $this->actingAs($user);

        $this->withoutMiddleware();

        $data =[
            'name'      => 'Test Office',
            'address'   => 'Test Rd, Test, Test TE1 4ST',
            'telephone' => '01803 123456',
        ];

        $this->call('POST', '/locations/add', $data);

        $this->assertResponseStatus(302);

        $this->notSeeInDatabase('locations', ['name' => 'Test Office']);
    }

    /**
     * @test
     * @group location
     * @group dom
     * @group persistence
     */
    public function location_page_displays_correct_data()
    {
        $this->createUserAndLogin();

        $location = factory(Location::class)->create();

        $this->visit($location->url)
                ->see($location->name)
                ->see($location->telephone);
    }

    /**
     * @test
     * @group location
     * @group permissions
     */
    public function add_new_department_button_shown_to_super_user()
    {
        $this->createUserAndLogin(1);

        $location = factory(Location::class)->create();

        $this->visit($location->url)
                ->see('Add New Department');
    }

    /**
     * @test
     * @group location
     * @group permissions
     */
    public function add_new_department_button_not_shown_to_non_super_user()
    {
        $this->createUserAndLogin();

        $location = factory(Location::class)->create();

        $this->visit($location->url)
                ->dontSee('Add New Department');
    }

}
