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
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
            ->see('Staff Directory');
    }

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

    public function request_to_show_department_returns_correct_data()
    {
        // @TODO write test
    }

    public function request_to_show_all_departments_returns_correct_data()
    {
        // @TODO write test
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
    public function adding_new_member_results_in_new_record_in_db()
    {
        $this->withoutMiddleware();

        $credentials = [
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

        $this->call('POST', '/member/add', $credentials);

        $this->assertResponseOk();

        $this->seeInDatabase('users', [
            'last_name' => 'Swift',
        ]);
    }
}
