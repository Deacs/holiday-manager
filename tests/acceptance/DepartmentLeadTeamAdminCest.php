<?php
use \AcceptanceTester;

class DepartmentLeadTeamAdminCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginEngineeringLeadUser($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function seeTeamMembers(AcceptanceTester $I)
    {
        $I->amOnPage('/department/engineering');
        $I->see('David Ives', '.member-link');
        $I->see('Rob Crowe', '.member-link');
        $I->see('Ben Christine', '.member-link');
    }

    public function seeHolidayRequestManagementOptions(AcceptanceTester $I)
    {
        $I->amOnPage('/department/engineering');
        $I->seeElement('#team-holiday-status');
        $I->seeElement('a', ['data-balance-type' => 'pending']);
        $I->seeElement('a', ['data-balance-type' => 'approved']);
        $I->seeElement('a', ['data-balance-type' => 'available']);
    }

    Public function canViewMemberProfileFromDepartmentListing(AcceptanceTester $I)
    {
        $I->amOnPage('/department/engineering');
        $I->click('Rob Crowe');
        $I->seeCurrentUrlEquals('/member/rob-crowe');
    }

    public function seeHolidayAdministrationOptionsForMembers(AcceptanceTester $I)
    {
        $I->amOnPage('/member/rob-crowe');
        $I->see('No approved holiday requests');
    }
}
