<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DepartmentTest extends CrowdcubeTester
{

//    use DatabaseMigrations;

    protected $baseUrl = 'http://caliente.dev';

    /**
     * @test
     */
    public function anonymous_users_are_redirected_to_login_when_requesting_engineering_route()
    {
        $this->visit('/departments/engineering')
                ->onPage('/login');
    }

    /**
     * @test
     */
    public function viewing_engineering_route_displays_correct_page()
    {
        Auth::loginUsingId(6);

        $this->visit('/departments/engineering')
                ->see('Engineering');
    }

    /**
     * @test
     */
    public function clicking_department_lead_name_opens_correct_profile_page()
    {
        Auth::loginUsingId(2);

        $this->visit('/departments/engineering')
                ->click('David Ives') // Element actually has a class of , .department-lead
                ->onPage('/member/david-ives');
    }

    /**
     * @test
     */
    public function add_new_member_form_displayed_to_team_lead()
    {
        Auth::loginUsingId(1);

        $this->visit('/departments/engineering')
                ->see('Add New Team Member');
    }

    /**
     * @not_test
     */
    public function add_new_member_form_displayed_to_super_user()
    {
        Auth::loginUsingId(15);

        $this->visit('/departments/investments')
                ->see('Add New Team Member');
    }

    /**
     * @test
     */
    public function add_new_member_form_not_displayed_to_standard_user()
    {
        Auth::loginUsingId(2);

        $this->visit('/departments/investments')
                ->dontSee('Add New Team Member');
    }

    /**
     * @test
     */
    public function adding_new_department_member_results_in_correct_data_being_persisted()
    {
        $this->withoutMiddleware();

        $data = [
            'first_name'    => 'Taylor',
            'last_name'     => 'Swift',
            'role'          => 'Junior Developer',
            'email'         => 'taylor@crowdcube.com',
            'skype_name'    => 'taylor.crowdcube',
            'telephone'     => '987654321',
            'extension'     => '123',
            'location_id'   => '1',
            'department_id' => '1',
        ];

        $this->call('POST', '/member/add', $data);

        $this->assertResponseOk();

        $this->seeInDatabase('users', $data);

        // A slug should have been automatically generated
        $this->seeInDatabase('users', ['slug' => 'taylor-swift']);
    }

    /**
     * @test
     */
    public function attempting_to_add_department_member_missing_required_fields_prevents_persistence()
    {
        $this->withoutMiddleware();

        $data = [
            'first_name'    => 'Taylor',
            'last_name'     => 'Swift',
            'role'          => 'Junior Developer',
            'email'         => 'taylor@crowdcube.com',
        ];

        $this->call('POST', '/member/add', $data);

        $this->assertResponseStatus(302);

        $this->notSeeInDatabase('users', $data);
    }

}
