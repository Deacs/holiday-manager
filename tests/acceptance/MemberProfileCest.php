<?php
use \AcceptanceTester;

class MemberProfileCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginEngineeringLeadUser($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function seeTheCorrectUsersFullName(AcceptanceTester $I)
    {
        $I->amOnPage('/member/david-ives');
        $I->see('David Ives', 'h1');
    }

    public function seeTheCorrectGravatar(AcceptanceTester $I)
    {
        $I->amOnPage('/member/david-ives');
        $I->seeImageWithSource('http://www.gravatar.com/avatar/2c5d2309bda85321f921c8b4e34aacaf?s=150&d=mm');
    }

    public function seeCorrectHolidayStatus(AcceptanceTester $I)
    {
        $I->amOnPage('/member/david-ives');
        $I->see('Holiday Status');
        $I->see('Not currently on leave');
        $I->see('No approved holiday requests');
    }
}
