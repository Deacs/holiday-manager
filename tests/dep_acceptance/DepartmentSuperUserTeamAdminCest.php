<?php
use \AcceptanceTester;

class DepartmentSuperUserTeamAdminCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginSuperUser($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function seeTeamMembers(AcceptanceTester $I)
    {
        $I->amOnPage('/departments/engineering');
        $I->see('David Ives', '.member-link');
        $I->see('Rob Crowe', '.member-link');
        $I->see('Ben Christine', '.member-link');
    }

    public function seeHolidayRequestManagementOptions(AcceptanceTester $I)
    {
        $I->amOnPage('/departments/engineering');
        $I->seeElement('#team-holiday-status');
        $I->seeElement('a', ['data-balance-type' => 'pending']);
        $I->seeElement('a', ['data-balance-type' => 'approved']);
        $I->seeElement('a', ['data-balance-type' => 'available']);
    }

    Public function canViewMemberProfileFromDepartmentListing(AcceptanceTester $I)
    {
        $I->amOnPage('/departments/engineering');
        $I->click('Rob Crowe');
        $I->seeCurrentUrlEquals('/member/rob-crowe');
    }

    public function seeCorrectGravatarForUser(AcceptanceTester $I)
    {
        $I->amOnPage('/departments/engineering');
        $I->seeImageWithSource('http://www.gravatar.com/avatar/'.md5(strtolower('rob@crowdcube.com')).'?s=20&d=mm', ['alt' => 'Rob Crowe']);
    }
}
