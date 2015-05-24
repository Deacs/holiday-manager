<?php
use \AcceptanceTester;

class GuestHeaderNavigationCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function cantSeeLoginOption(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Login');
        $I->dontSee('Logout');
    }

    public function cantSeeProfileOption(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->dontSee('Profile');
    }

    public function cantSeeTeamOptions(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->dontSee('Teams');
    }
}
