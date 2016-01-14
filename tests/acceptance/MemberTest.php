<?php

use App\User;
use App\Department;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MemberTest extends CrowdcubeTester
{

    protected $baseUrl = 'http://caliente.dev';

    /**
     * @test
     * @group user_test
     */
    public function see_root_page()
    {
        $this->visit('/')
            ->see('Staff Directory');
    }

    /**
     * @vue_test
     */
    public function edit_option_is_shown_to_standard_user_when_viewing_own_user_profile()
    {
        Auth::loginUsingId(2);

        // Issues with checking DOM for elements created with VueJS
        $this->visit('/member/rob-crowe');
        $this->see('EDIT USER');
    }

    /**
     * @vue_test
     * @group vue_permissions
     */
    public function standard_user_can_open_edit_user_screen_to_update_own_details()
    {
        $user = $this->createUserAndLogin();

        // Issues with checking DOM for elements created with VueJS
        $this->visit($user->url)
                ->see('EDIT USER')
                ->click('EDIT USER')
                ->onPage($user->url.'/edit');
    }

    /**
     * @test
     * @group user
     */
    public function standard_user_attempting_to_view_edit_details_screen_for_another_user_receives_unauthorised_response()
    {
        $department = factory(Department::class)->create(['lead_id' => 1]);
        $user       = factory(User::class)->create(['department_id' => $department->id]);

        $this->createUserAndLogin();

        $this->get($user->url.'/edit')
                ->assertResponseStatus(403);
    }

    /**
     * @test
     * @group user_test
     */
    public function department_lead_attempting_to_view_edit_details_screen_for_another_user_receives_200_response()
    {
        $department = factory(Department::class)->create(['lead_id' => 1]);
        $user       = factory(User::class)->create(['id' => $department->lead_id, 'department_id' => $department->id]);
        $userTwo    = factory(User::class)->create(['department_id' => $department->id]);

        Auth::loginUsingId($user->id);

        $this->get($userTwo->url.'/edit')
                ->assertResponseOk();
    }

    /**
     * @test
     * @group user_test
     */
    public function super_user_attempting_to_view_edit_details_screen_for_another_user_receives_200_response()
    {
        $department = factory(Department::class)->create(['lead_id' => 10]);
        $user       = factory(User::class)->create(['super_user' => 1, 'department_id' => $department->id]);
        $userTwo    = factory(User::class)->create(['department_id' => $department->id]);

        Auth::loginUsingId($user->id);

        $this->get($userTwo->url.'/edit')
                ->assertResponseOk();
    }

    /**
     * @vue_test
     * @group vue_user
     */
    public function department_lead_can_edit_user_details_for_members_of_their_own_team()
    {
        $department = factory(Department::class)->create(['lead_id' => 1]);
        $user       = factory(User::class)->create(['id' => $department->lead_id, 'department_id' => $department->id]);
        $userTwo    = factory(User::class)->create(['department_id' => $department->id]);

        Auth::loginUsingId($user->id);

        $this->get($userTwo->url.'/edit')
                ->see('Edit Details')
                ->submitForm('Update',
                    [
                        'first_name'    => 'Billy',
                        'last_name'     => 'Bunter',
                    ]
                )
                ->seeInDatabase('users',
                    [
                        'first_name'    => 'Billy',
                        'last_name'     => 'Bunter',
                        'email'         => $userTwo->email,
                        'slug'          => 'billy-bunter',
                    ]
                );
    }

    /**
     * @test
     * @group user
     */
    public function super_user_can_edit_user_details_of_any_member()
    {
        Auth::loginUsingId(15);

        $this->visit('/member/rob-crowe/edit')
                ->see('Edit Details')
                ->submitForm('Update',
                    [
                        'first_name'    => 'Roberto',
                        'last_name'     => 'Crowington',
                    ]
                )
                ->seeInDatabase('users',
                    [
                        'first_name'    => 'Roberto',
                        'last_name'     => 'Crowington',
                        'email'         => 'rob@crowdcube.com',
                        'slug'          => 'roberto-crowington',
                    ]
                );
    }

    /**
     * @test
     * @group user
     */
    public function edit_avatar_option_is_available_to_profile_owner()
    {
        Auth::loginUsingId(2);

        $user = $this->createUserAndLogin();

        $this->visit($user->url.'/edit')
                ->see('Drag your new avatar here');
    }

}
