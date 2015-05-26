<?php
use \AcceptanceTester;

class FailedLoginCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginWithIncorrectDetails($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function seeErrorMessageFlashOnEnteringIncorrectDetails(AcceptanceTester $I)
    {
        $I->seeCurrentUrlEquals('/login');
        $I->see('Entered email or password incorrect. Please try again', '.alert');
        $I->seeElement('.close');
        $I->click(['class' => 'close']);
        $I->dontSee('Entered email or password incorrect. Please try again', '.alert');
    }
}
