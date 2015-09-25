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
    public function edit_option_is_not_shown_to_standard_user_when_viewing_another_users_profile()
    {
        Auth::loginUsingId(2);

        $this->visit('/member/david-ives')
                ->dontSee('Edit User');
    }
}
