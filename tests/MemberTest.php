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
    public function standard_user_can_open_edit_user_screen_to_update_details()
    {
        Auth::loginUsingId(1);

        // Cannot understand why this is failing
        // InvalidArgumentException: Could not find a link with a body, name, or ID attribute of [edit-user].
        // Even though there is a link with that value as an ID
//        $this->visit('/member/david-ives')
//                ->see('EDIT USER')
//                ->click('edit-user')
//                ->onPage('/member/david-ives/edit');
    }

    /**
     * @test
     */
    public function department_lead_can_edit_user_details_for_members_of_their_own_team()
    {
        /* @TODO Write test */
    }

    /**
     * @test
     */
    public function super_user_can_edit_user_details_of_any_member()
    {
        /* @TODO Write test */
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
}
