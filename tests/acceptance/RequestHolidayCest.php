<?php
use \AcceptanceTester;

class RequestHolidayCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginUser($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group new
     */
    public function canSeeHolidayRequestForm(AcceptanceTester $I)
    {
        $I->am('the logged in member');
        $I->amOnPage('/member/tom-leigh');
        // Check for "hero" panel or similar that will hold the form
        $I->see('Request Holiday', 'h4');
        $I->see('Start Date:', 'label');
//        $I->seeElement('');
        $I->see('End Date:', 'label');
        $I->see('Place Request', '.button');
        $I->click('Place Request');
    }
}
