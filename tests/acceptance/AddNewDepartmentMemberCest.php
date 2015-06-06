<?php
use \AcceptanceTester;

class AddNewDepartmentMemberCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginEngineeringLeadUser($I);
        $I->am('Engineering Lead');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group new
     */
    public function canCreateNewMemberForEngineeringDepartment(AcceptanceTester $I)
    {
        $I->registerNewUser($I);

        $I->seeCurrentUrlEquals('/department/engineering');
        $I->see('Member Successfully Added', '.success');
        // New user should now be visible within listing
        $I->see('Jack Way', '.member-link');
        $I->see('Front End Engineer');
        $I->see('jack.way@crowdcube.com');
        $I->click('Jack Way');
        $I->seeCurrentUrlEquals('/member/jack-way');

        $I->seeInDatabase('users',
            [
                'first_name'    => 'Jack',
                'last_name'     => 'Way',
                'confirmed'     => 0
            ]
        );
    }
}
