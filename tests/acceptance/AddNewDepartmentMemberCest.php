<?php
use \AcceptanceTester;
use App\User;

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

    /**
     * @group new
     */
    public function canConfirmAccountFromTokenLinkUpdatePasswordAndLogin(AcceptanceTester $I)
    {
        $I->registerNewUser($I);
        $I->logoutUser($I);
        $confirmation_token = $I->grabFromDatabase('users', 'confirmation_token', ['email' => 'jack.way@crowdcube.com']);
        $I->amOnPage('member/confirm/'.$confirmation_token);

        // If the User can be found in the correct state, they can create a password
        $I->see('Confirm Your Account', 'h1');
        $I->see('Please create a password to complete the confirmation of your account.', 'p');
        $I->fillField('password', 'jack');
        $I->fillField('password_confirmation', 'jack');
        $I->click('Confirm');
        $I->seeCurrentUrlEquals('/member/jack-way');
        $I->see('Account Successfully Confirmed');
    }
}
