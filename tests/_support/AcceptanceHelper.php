<?php
namespace Codeception\Module;

use AcceptanceTester;
use App\User;
use Codeception\Module;

class AcceptanceHelper extends Module
{
    /**
     * Login a regular member
     *
     * @param AcceptanceTester $I
     */
    public function loginUser(AcceptanceTester $I)
    {
        $this->login($I, 'tom.leigh@crowdcube.com', 'tom');
    }

    /**
     * Login the Lead for the Engineering Department
     *
     * @param AcceptanceTester $I
     */
    public function loginEngineeringLeadUser(AcceptanceTester $I)
    {
        $this->login($I, 'david@crowdcube.com', 'david');
    }

    /**
     * Login the Super User
     *
     * @param AcceptanceTester $I
     */
    public function loginSuperUser(AcceptanceTester $I)
    {
        $this->login($I, 'darren.westlake@crowdcube.com', 'darren');
    }

    // And this function lets me login a specific user if I need someone else
    public function login(AcceptanceTester $I, $email, $password)
    {
//        $user = User::where('email', $email)->get();
//
//        dd($user);

        $I->amOnPage('/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click('Login', '.btn-primary');
//        $I->seeCurrentUrlEquals('/member/'.$user->slug);
    }

    public function logoutUser(AcceptanceTester $I)
    {
        $I->amOnPage('/logout');
        $I->seeCurrentUrlEquals('/login');
        $I->see('You have been logged out');
    }
}
