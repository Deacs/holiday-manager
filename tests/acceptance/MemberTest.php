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
     * @group user
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
        $user = $this->createUserAndLogin();

        // Issues with checking DOM for elements created with VueJS
        $this->visit($user->url);
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
     * @group user
     */
    public function department_lead_attempting_to_view_edit_details_screen_for_another_user_receives_200_response()
    {
        $department = factory(Department::class)->create(['lead_id' => 1]);
        $user       = factory(User::class)->create(['id' => $department->lead_id, 'department_id' => $department->id]);
        $userTwo    = factory(User::class)->create(['department_id' => $department->id]);

        $this->actingAs($user);

        $this->get($userTwo->url.'/edit')
                ->assertResponseOk();
    }

    /**
     * @test
     * @group user
     */
    public function super_user_attempting_to_view_edit_details_screen_for_another_user_receives_200_response()
    {
        $department = factory(Department::class)->create(['lead_id' => 10]);
        $user       = factory(User::class)->create(['super_user' => 1, 'department_id' => $department->id]);
        $userTwo    = factory(User::class)->create(['department_id' => $department->id]);

        $this->ActingAs($user);

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
        $user = $this->createUser();

        $superUser = $this->createSuperUser();
        $this->actingAs($superUser);

        $updated = [
            'first_name'    => $user->first_name.'_updated',
            'last_name'     => $user->last_name.'_updated',
        ];

        $this->seeInDatabase('users',
            [
                'first_name'    => $user->first_name,
                'last_name'     => $user->last_name,
                'email'         => $user->email,
                'slug'          => $user->slug,
            ]
        );

        $this->visit($user->url.'/edit')
                ->see('Edit Details')
                ->submitForm('Update',
                    [
                        'first_name'    => $updated['first_name'],
                        'last_name'     => $updated['last_name'],
                    ]
                )
                ->seeInDatabase('users',
                    [
                        'first_name'    => $updated['first_name'],
                        'last_name'     => $updated['last_name'],
                        'email'         => $user->email,
                        'slug'          => Str::slug(join([$updated['first_name'], $updated['last_name']], ' ')),
                    ]
                );
    }

    /**
     * @test
     * @group user
     */
    public function edit_avatar_option_is_available_to_profile_owner()
    {
        $user = $this->createUserAndLogin();

        $this->visit($user->url.'/edit')
                ->see('Drag your new avatar here');
    }

}
