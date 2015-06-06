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

    public function can_create_new_member_for_engineering_department(AcceptanceTester $I)
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
    public function can_confirm_account_from_token_link_then_update_password_and_login(AcceptanceTester $I)
    {
        $I->registerNewUser($I);
        $I->logoutUser($I);
        $confirmation_token = $I->grabFromDatabase('users', 'confirmation_token', ['email' => 'jack.way@crowdcube.com']);
        $I->amOnPage('member/confirm/'.$confirmation_token);

        // If the User can be found in the correct state, they can create a password
        $I->see('Confirm Your Account', 'h1');
        $I->see('Please create a password to complete the confirmation of your account.', 'p');
        $I->fillField('password', 'jackway');
        $I->fillField('password_confirmation', 'jackway');
        $I->click('Confirm', '.button');
        $I->seeCurrentUrlEquals('/member/jack-way');
        $I->see('Account Successfully Confirmed');
        $I->click('Jack Way');
        $I->see('Profile');
        $I->see('Logout');
    }

    /**
     * @group pending
     */
    public function mismatched_password_and_confirmation_will_prevent_account_confirmation_and_display_errors(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }

    /**
     * @group pending
     * @TODO Move to correct suite
     */
    public function unconfirmed_accounts_cannot_login(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }
}
