<?php
namespace AcceptanceTester;

class MemberSteps extends \AcceptanceTester
{
    public function loginMember($email, $password)
    {
        $I = $this;
        $I->amOnPage(\LoginPage::$URL);
        $I->fillField(\LoginPage::$usernameField, $email);
        $I->fillField(\LoginPage::$passwordField, $password);
        $I->click(\LoginPage::$loginButton);
    }

    public function loginEngineeringLead($email, $password)
    {
        $I = $this;
        $I->amOnPage(\LoginPage::$URL);
        $I->fillField(\LoginPage::$usernameField, $email);
        $I->fillField(\LoginPage::$passwordField, $password);
        $I->click(\LoginPage::$loginButton);
    }

    public function loginInvestmentsLead($email, $password)
    {
        $I = $this;
        $I->amOnPage(\LoginPage::$URL);
        $I->fillField(\LoginPage::$usernameField, $email);
        $I->fillField(\LoginPage::$passwordField, $password);
        $I->click(\LoginPage::$loginButton);
    }

    public function loginSuperUser($email, $password)
    {
        $I = $this;
        $I->amOnPage(\LoginPage::$URL);
        $I->fillField(\LoginPage::$usernameField, $email);
        $I->fillField(\LoginPage::$passwordField, $password);
        $I->click(\LoginPage::$loginButton);
    }
}
