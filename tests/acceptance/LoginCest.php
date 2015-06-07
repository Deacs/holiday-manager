<?php
use \AcceptanceTester;

class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function can_login_successfully(AcceptanceTester $I)
    {
        $I->click('Login');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'ben@crowdcube.com');
        $I->fillField('password', 'ben');
        $I->click('Login', '.btn-primary');
        $I->seeCurrentUrlEquals('/member/ben-christine');
    }

    /**
     * @group pending
     * Only users with confirmed account can login
     *
     * @TODO Move to correct suite
     */
    public function unconfirmed_accounts_cannot_login(AcceptanceTester $I)
    {
        $I->loginEngineeringLeadUser($I);
        $I->registerNewUser($I);
        $I->logoutUser($I);
        $I->amOnPage('/login');
        $I->fillField('email', 'jack@crowdcube.com');
        $I->fillField('password', 'anything');
        $I->click('Login', '.btn-primary');
        $I->see('Account has not been confirmed. Please check your email for confirmation details.', '.alert');
    }
}
