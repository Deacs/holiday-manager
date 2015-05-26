<?php
use \AcceptanceTester;

class FailedLoginCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginWithIncorrectDetails($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function seeLogoutOption(AcceptanceTester $I)
    {
        $I->seeCurrentUrlEquals('/login');
        $I->see('Entered email or password incorrect. Please try again', '.alert');
    }
}
