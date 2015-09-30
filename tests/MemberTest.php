<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MemberTest extends TestCase
{

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
    public function edit_option_is_shown_to_standard_user_when_viewing_own_user_profile()
    {
        Auth::loginUsingId(2);

        $this->visit('/member/rob-crowe')
                ->see('EDIT USER');
    }

    /**
     * @test
     */
    public function standard_user_can_open_edit_user_screen_to_update_own_details()
    {
        Auth::loginUsingId(2);

        $this->visit('/member/rob-crowe')
                ->see('EDIT USER')
                ->click('EDIT USER')
                ->onPage('/member/rob-crowe/edit');
    }

    /**
     * @test
     */
    public function standard_user_attempting_to_view_edit_details_screen_for_another_user_receives_unauthorised_response()
    {
        Auth::loginUsingId(2);

        $this->get('/member/david-ives/edit')
                ->assertResponseStatus(403);
    }

    /**
     * @test
     */
    public function department_lead_attempting_to_view_edit_details_screen_for_another_user_receives_200_response()
    {
        Auth::loginUsingId(1);

        $this->get('/member/rob-crowe/edit')
            ->assertResponseOk();
    }

    /**
     * @test
     */
    public function super_user_attempting_to_view_edit_details_screen_for_another_user_receives_200_response()
    {
        Auth::loginUsingId(15);

        $this->get('/member/becca-lewis/edit')
            ->assertResponseOk();
    }

    /**
     * @test
     */
    public function department_lead_can_edit_user_details_for_members_of_their_own_team()
    {
        Auth::loginUsingId(1);

        $this->visit('/member/rob-crowe/edit')
                ->see('Edit Details')
                ->type('Roberto', 'first_name')
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
                    ]
                );
    }

    /**
     * @test
     */
    public function super_user_can_edit_user_details_of_any_member()
    {
        /* @TODO Write test */
    }

}
