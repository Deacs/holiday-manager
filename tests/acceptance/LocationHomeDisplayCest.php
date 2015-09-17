<?php
use \AcceptanceTester;

class LocationHomeDisplayCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->am('a logged in user');
        $I->loginUser($I);
        $I->amOnPage('/location/exeter');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function seeCorrectAddress(AcceptanceTester $I)
    {
        $I->see('Innovation Centre');
    }

    public function seeCorrectTelephoneNumber(AcceptanceTester $I)
    {
        $I->see('01392 241319');
    }

    public function seeDepartmentListing(AcceptanceTester $I)
    {
        $I->see('Engineering', 'a');
        $I->click('Engineering');
        $I->seeCurrentUrlEquals('/departments/engineering');
    }
}
