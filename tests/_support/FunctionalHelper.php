<?php
namespace Codeception\Module;

use FunctionalTester;
use Codeception\Module;

class FunctionalHelper extends Module
{
    public function notHelpingAnything()
    {

    }

    /**
     * Login the Lead for the Engineering Department
     *
     * @param FunctionalTester $I
     */
    public function loginEngineeringLeadUser(FunctionalTester $I)
    {
//        $this->login($I, 'david@crowdcube.com', 'david');
    }

    /**
     * Login the user with the required details
     *
     * @param FunctionalTester $I
     * @param $email
     * @param $password
     */
    public function login(FunctionalTester $I, $email, $password)
    {
//        $I->amOnPage('/login');
//        $I->fillField('email', $email);
//        $I->fillField('password', $password);
//        $I->click('Login', '.btn-primary');
    }

    public function registerNewUser(FunctionalTester $I)
    {
//        $I->amOnPage('/department/engineering');
//        $I->fillField('first_name', 'Jack');
//        $I->fillField('last_name', 'Way');
//        $I->fillField('role', 'Front End Engineer');
//        $I->fillField('email', 'jack.way@crowdcube.com');
//        $I->selectOption('location_id', '1');
//        $I->selectOption('department_id', '1');
//        $I->click('Add');
    }
}
