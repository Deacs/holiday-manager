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

    public function dontSeeLoginOption(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Login');
        $I->dontSee('Logout');
    }

    public function dontSeeTeamOptions(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->dontSee('Teams');
    }
}
