<?php

use App\HolidayRequest;

class HolidayRequestValidationCest
{
    /**
     * @var \UnitTester
     */
//    protected $tester;

    protected function _before(UnitTester $I)
    {

    }

    protected function _after()
    {
    }

    // tests
    public function testBasicHolidayRequestCanBeRecorded(UnitTester $I)
    {
        $I->addUnapprovedRequest();
        $I->seeInDatabase('users', ['email' => 'david@crowdcube.com']);
        $I->seeInDatabase('holiday_requests', ['user_id' => '123']);
    }
}
