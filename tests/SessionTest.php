<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchTest extends TestCase
{

    protected $baseUrl = 'http://caliente.dev';

    /**
     * @test
     */
    public function can_login()
    {
        $this->visit('/')
            ->see('Login')
            ->click('Login')
            ->type('david@crowdcube.com', 'email')
            ->type('david', 'password');
    }

    /**
     * @test
     */
    public function anonymous_users_are_redirected_to_login_when_visiting_content_pages()
    {
        $this->visit('/departments/engineering')
                ->onPage('/login');
    }
}
