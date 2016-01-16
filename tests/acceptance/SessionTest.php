<?php

use App\User;
use App\Department;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchTest extends CrowdcubeTester
{

    protected $baseUrl = 'http://caliente.dev';

    /**
     * @not_test
     */
    public function can_login()
    {
        $user = factory(User::class)->create(['email' => 'a@b.com', 'password' => 'secret']);

        $this->visit('/login')
            ->see('Login')
            ->type('a@b.com', 'email')
            ->type('secret', 'password')
            ->press('login_button')
            ->seePageIs($user->url);
    }

    /**
     * @test
     */
    public function anonymous_users_are_redirected_to_login_when_visiting_content_pages()
    {
        $department = factory(Department::class)->create();

        $this->visit($department->url)
                ->seePageIs('/login');
    }
}
