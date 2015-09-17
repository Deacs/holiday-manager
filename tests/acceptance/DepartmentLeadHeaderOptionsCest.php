<?php
use \AcceptanceTester;

class DepartmentLeadHeaderOptionsCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginEngineeringLeadUser($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function seeMyTeamOption(AcceptanceTester $I)
    {
        $I->see('My Team');
        $I->click('My Team');
        $I->seeCurrentUrlEquals('/departments/engineering');
    }
}
