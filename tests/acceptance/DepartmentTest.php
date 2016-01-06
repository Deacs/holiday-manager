<?php

use App\User;
use Carbon\Carbon;
use App\Department;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DepartmentTest extends CrowdcubeTester
{
    use DatabaseTransactions;

    protected $baseUrl = 'http://caliente.dev';

    /**
     * @test
     * @group department
     * @group permissions
     */
    public function anonymous_users_are_redirected_to_login_when_requesting_engineering_route()
    {
        $department = factory(Department::class)->create();

        $this->visit($department->url)
                ->seePageIs('/login');
    }

    /**
     * @test
     * @group department
     * @group routing
     */
    public function viewing_department_route_displays_correct_page()
    {
        $department = factory(Department::class)->create(['lead_id' => 1]);
        $lead       = factory(User::class)->create(['id' => $department->lead_id, 'department_id' => $department->id]);

        $this->createUserAndLogin();

        $this->visit($department->url)
                ->see($department->name);
    }

    /**
     * @test
     * @group department
     * @group routing
     */
    public function clicking_department_lead_name_opens_correct_profile_page()
    {
        $department = factory(Department::class)->create(['lead_id' => 1]);
        $lead       = factory(User::class)->create(['id' => $department->lead_id, 'department_id' => $department->id]);

        $this->createUserAndLogin();

        $this->visit($department->url)
                ->click('department-lead')
                ->seePageIs($lead->url);
    }

    /**
     * @test
     * @group department
     * @group permissions
     */
    public function add_new_member_form_displayed_to_team_lead()
    {
        $department = factory(Department::class)->create(['lead_id' => 1]);
        $user       = factory(User::class)->create(['id' => $department->lead_id, 'department_id' => $department->id]);

        Auth::loginUsingId($user->id);

        $this->visit($department->url)
                ->see('Add New Team Member');
    }

    /**
     * @test
     * @group department
     * @group permissions
     */
    public function add_new_member_form_displayed_to_super_user()
    {
        $department = factory(Department::class)->create(['lead_id' => 1]);
        $user       = factory(User::class)->create(['id' => $department->lead_id, 'department_id' => $department->id]);

        $this->createUserAndLogin(1);

        $this->visit($department->url)
                ->see('Add New Team Member');
    }

    /**
     * @test
     * @group department
     * @group permissions
     */
    public function add_new_member_form_not_displayed_to_standard_user()
    {
        $department = factory(Department::class)->create(['lead_id' => 1]);
        $user       = factory(User::class)->create(['id' => $department->lead_id, 'department_id' => $department->id]);

        $this->createUserAndLogin();

        $this->visit($department->url)
                ->dontSee('Add New Team Member');
    }

    /**
     * @test
     * @group department
     * @group persistence
     */
    public function adding_new_department_member_results_in_correct_data_being_persisted()
    {
        $department = factory(Department::class)->create(['id' => 1, 'lead_id' => 1]);
        $user       = factory(User::class)->create(['id' => $department->lead_id, 'department_id' => $department->id]);

        Auth::loginUsingId($user->id);

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
            'department_id' => $department->id,
        ];

        $this->call('POST', '/member/add', $data);

        $this->assertResponseOk();

        $this->seeInDatabase('users', $data);

        // A slug should have been automatically generated
        $this->seeInDatabase('users', ['slug' => 'taylor-swift']);
    }

    /**
     * @test
     * @group department
     * @group persistence
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
    
    /**
     * @vue_test
     * @group vue_department
     * @TODO use factories
     */
    public function viewing_department_index_displays_correct_departments()
    {
        $departments = factory(Department::class, 4)->create();

        $this->createUserAndLogin();

        $this->visit('/departments/')
                ->see($departments[0])
                ->see($departments[1])
                ->see($departments[2])
                ->see($departments[3]);
    }

    /**
     * @vue_test
     * @group vue_department
     * @group vue_dom
     */
    public function clicking_department_name_in_listing_opens_correct_department_page()
    {
        // Vue generated list - cannot test
        $departments = factory(Department::class, 4)->create();

        $this->createUserAndLogin();

        $this->visit('/departments')
                ->click('Business Development')
                ->seePageIs('/departments/business-development')
                ->see('Business Development')
                ->see('Department Lead')
                ->see('Matt Cooper');
    }

    /**
     * @test
     * @group department
     * @group permissions
     */
    public function update_org_chart_option_not_shown_to_standard_user()
    {
        $department = factory(Department::class)->create(['lead_id' => 1]);
        $user       = factory(User::class)->create(['id' => $department->lead_id, 'department_id' => $department->id]);

        $this->createUserAndLogin();

        $this->visit($department->url)
                ->dontSee('Update Organisational Chart');
    }

    /**
     * @test
     * @group department
     * @group permissions
     */
    public function update_org_chart_option_shown_to_department_lead()
    {
        $department = factory(Department::class)->create(['lead_id' => 1]);
        $user       = factory(User::class)->create(['id' => $department->lead_id, 'department_id' => $department->id]);

        Auth::loginUsingId($user->id);

        $this->visit($department->url)
                ->see('Update Organisational Chart');
    }

    /**
     * @test
     * @group department
     * @group permissions
     */
    public function non_super_user_attempting_to_view_add_department_screen_is_redirected_to_login()
    {
        $department = factory(Department::class)->create(['lead_id' => 1]);
        $user       = factory(User::class)->create(['id' => $department->lead_id, 'department_id' => $department->id]);

        $this->createUserAndLogin();

        $this->visit('/departments/add')
            ->seePageIs('/login');
    }

    /**
     * @test
     * @group department
     * @group permissions
     */
    public function non_super_user_attempting_to_add_new_department_receives_unauthorised_response()
    {
        $department = factory(Department::class)->create(['lead_id' => 1]);
        $user       = factory(User::class)->create(['id' => $department->lead_id, 'department_id' => $department->id]);

        $this->createUserAndLogin();

        $this->withoutMiddleware();

        $this->post('/departments/add')
                ->assertResponseStatus(403);
    }

    /**
     * @test
     * @group department
     * @group permissions
     */
    public function super_user_adding_new_location_results_in_correct_data_being_persisted()
    {
        $department = factory(Department::class)->create();
        $user       = factory(User::class)->create(['department_id' => $department->id]);

        $this->createUserAndLogin(1);

        $this->withoutMiddleware();

        $data = [
            'name'          => 'Test Department',
            'lead_id'       => 1,
            'location_id'   => 2,
        ];

        $this->call('POST', '/departments/add', $data);

        $this->assertResponseStatus(302);

        $this->seeInDatabase('departments', $data);

        // A slug should have been automatically generated
        $this->seeInDatabase('departments', ['slug' => 'test-department']);
    }

    /**
     * @test
     * @group department
     * @group persistence
     */
    public function attempting_to_add_department_missing_required_fields_prevents_persistence()
    {
        $this->createUserAndLogin(1);

        $this->withoutMiddleware();

        $data = [
            'name'          => 'Test Department',
            'location_id'   => 2,
        ];

        $this->call('POST', '/departments/add', $data);

        $this->assertResponseStatus(302);

        $this->notSeeInDatabase('departments', $data);
    }

    /**
     * @test
     * @group department
     * @group validation
     */
    public function persistence_is_prevented_when_attempting_to_add_department_with_an_already_existing_name()
    {
        $department = factory(Department::class)->create(['name' => 'Test Department', 'location_id' => 1, 'lead_id' => 2]);

        $this->createUserAndLogin(1);

        $this->withoutMiddleware();

        $data = [
            'name'          => 'Test Department',
            'location_id'   => 3,
            'lead_id'       => 4,
        ];

        $this->call('POST', '/departments/add', $data);

        $this->assertResponseStatus(302);

        $this->notSeeInDatabase('departments', $data);
    }

    /**
     * @test
     * @group department
     * @group dom
     */
    public function add_department_form_renders_correct_fields()
    {
        $this->createUserAndLogin(1);

        $this->visit('/departments/add')
                ->see('Add new Department');
    }

    /**
     * @test
     * @group vue
     */
    public function typing_into_filter_minimises_available_results_correctly()
    {
        Auth::loginUsingId(3);

        // There is a real issue with elements that are created by Vue JS templates
        // It would appear that the crawler can't interact with them - yet it can see the placeholder text

//        $this->visit('/departments')
//                ->see('Start typing any of the fields below to search....')
//                ->type('mar', 'department_search')
//                ->see('Marketing')
//                ->dontSee('Engineering');
    }
}
