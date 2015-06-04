<?php
use \AcceptanceTester;

class DepartmentHomeDisplayCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginUser($I);
    }

    public function openDepartmentHomePageAndNavigateToMemberProfile(AcceptanceTester $I)
    {
        $I->amOnPage('/department/engineering');
        $I->see('Engineering');
        $I->see('Department Lead: David Ives');
        $I->see('Team Members');
        $I->see('Rob Crowe');
        $I->click('Rob Crowe');
        $I->canSeeCurrentUrlEquals('/member/rob-crowe');
    }

    public function seeCorrectMessageForTeamWithMembers(AcceptanceTester $I)
    {
        $I->amOnPage('/department/product');
        $I->see('Product');
        $I->see('Department Lead: Thor Mitchell');
        $I->dontSee('No team members associated with Product');
    }

    public function cantSeeAddNewMemberForm(AcceptanceTester $I)
    {
        $I->amOnPage('/department/engineering');
        $I->dontSee('Add New Team Member');
    }
}
