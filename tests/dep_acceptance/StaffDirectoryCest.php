<?php
use \AcceptanceTester;

class StaffDirectoryCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginUser($I);
        $I->amOnPage('/directory');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function seeCorrectDefaultTable(AcceptanceTester $I)
    {
        $I->see('Staff Directory', 'h1');
        $I->seeElement('table', ['id' => 'staff-directory']);
    }

   public function seeUserHomeFromListingLink(AcceptanceTester $I)
    {
        $I->see('Rebecca Hand', 'a');
        $I->click('Rebecca Hand');
        $I->seeCurrentUrlEquals('/member/rebecca-hand');
    }

    public function seeDepartmentHomeFromListingLink(AcceptanceTester $I)
    {
        $I->see('Business Development', 'a');
        $I->click('Business Development');
        $I->seeCurrentUrlEquals('/departments/business-development');
    }
}
