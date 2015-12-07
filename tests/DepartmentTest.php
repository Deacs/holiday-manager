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
     * @test
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
    
    /**
     * @test
     */
    public function viewing_department_index_displays_correct_departments()
    {
        Auth::loginUsingId(3);

        $this->visit('/departments/')
                ->see('Engineering')
                ->see('Marketing')
                ->see('Investments')
                ->see('Product')
                ->see('Completions')
                ->see('Finance')
                ->see('Legal')
                ->see('Bonds')
                ->see('Business Development')
                ->see('Gateway');
    }

    /**
     * @test
     */
    public function clicking_department_name_in_listing_opens_correct_department_page()
    {
        Auth::loginUsingId(3);

        $this->visit('/departments')
                ->click('Business Development')
                ->onPage('/departments/business-development')
                ->see('Business Development')
                ->see('Department Lead')
                ->see('Matt Cooper')
                ->see('Team Members');
    }

    /**
     * @test
     * @group permissions
     */
    public function update_org_chart_option_not_shown_to_standard_user()
    {
        Auth::loginUsingId(3);

        $this->visit('/departments/engineering')
                ->dontSee('Update Organisational Chart');
    }

    /**
     * @test
     * @group permissions
     */
    public function update_org_chart_option_shown_to_department_lead()
    {
        Auth::loginUsingId(1);

        $this->visit('departments/engineering')
                ->see('Update Organisational Chart');
    }

    /**
     * @test
     * @group vue
     */
    public function typing_into_filter_minimises_available_results_correctly()
    {
        Auth::loginUsingId(3);

        // There is a real issue with elements that are created by Vue JS templates
        // It would appear that the crawler can't interact them - yet it can see the placeholder text

//        $this->visit('/departments')
//                ->see('Start typing any of the fields below to search....')
//                ->type('mar', 'department_search')
//                ->see('Marketing')
//                ->dontSee('Engineering');
    }
}
