<?php
use \AcceptanceTester;

class AuthenticatedHeaderNavigationCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginUser($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function seeLogoutOption(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Logout');
        $I->dontSee('Login');
    }
}
