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

    public function seeLogoutOption(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Logout');
        $I->dontSee('Login');
    }

    public function seeTeamsOptions(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Teams');
        $I->click('Teams');
        $I->see('Exeter');
        $I->see('London');
        $I->see('Edinburgh');
    }

    public function seeProfileOption(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Profile');
        $I->click('Profile');
        $I->seeCurrentUrlEquals('/member/tom-leigh');
        $I->see('Tom Leigh');
    }

    public function cantSeeMyTeamOption(AcceptanceTester $I)
    {
        $I->dontSeeElement('My Team');
    }
}
