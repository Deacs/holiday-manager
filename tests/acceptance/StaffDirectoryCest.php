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

    /**
     * @group new
     */
    public function seeUserListing(AcceptanceTester $I)
    {
        $I->see('Rebecca Hand', 'a');
        $I->click('Rebecca Hand');
        $I->seeCurrentUrlEquals('/member/rebecca-hand');
    }
}
