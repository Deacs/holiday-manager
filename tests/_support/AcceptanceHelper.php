<?php
namespace Codeception\Module;

use AcceptanceTester;
use Codeception\Module;

class AcceptanceHelper extends Module
{

    /**
     * Login a regular member
     *
     * @param AcceptanceTester $I
     */
    public function loginUser(AcceptanceTester $I)
    {
        $this->login($I, 'tom.leigh@crowdcube.com', 'tom');
    }

    /**
     * Login the Lead for the Engineering Department
     *
     * @param AcceptanceTester $I
     */
    public function loginEngineeringLeadUser(AcceptanceTester $I)
    {
        $this->login($I, 'david@crowdcube.com', 'david');
    }

    /**
     * Login the Super User
     *
     * @param AcceptanceTester $I
     */
    public function loginSuperUser(AcceptanceTester $I)
    {
        $this->login($I, 'darren.westlake@crowdcube.com', 'darren');
    }

    /**
     * Fail auth by providing incorrect details
     *
     * @param AcceptanceTester $I
     */
    public function loginWithIncorrectDetails(AcceptanceTester $I)
    {
        $this->login($I, 'not.real@crowdcube.com', 'fail');
    }

    /**
     * Login the user with the required details
     *
     * @param AcceptanceTester $I
     * @param $email
     * @param $password
     */
    public function login(AcceptanceTester $I, $email, $password)
    {
        $I->amOnPage('/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click('Login', '.btn-primary');
    }

    /**
     * Log the user out
     *
     * @param AcceptanceTester $I
     */
    public function logoutUser(AcceptanceTester $I)
    {
        $I->amOnPage('/logout');
        $I->seeCurrentUrlEquals('/login');
        $I->see('You have been logged out');
    }

    public function registerNewUser(AcceptanceTester $I)
    {
        $I->amOnPage('/department/engineering');
        $I->fillField('first_name', 'Jack');
        $I->fillField('last_name', 'Way');
        $I->fillField('role', 'Front End Engineer');
        $I->fillField('email', 'jack.way@crowdcube.com');
        $I->selectOption('location_id', '1');
        $I->selectOption('department_id', '1');
        $I->click('Add');
    }

    /**
     * Check an image is available with the specified source
     * This is simply a utility to wrap the seeElement
     * method to be more readable for checking image paths
     *
     *
     * @throws \Codeception\Exception\Module
     * @param $image_url
     * @param array $data
     */
    public function seeImageWithSource($image_url, array $data = null)
    {
        $phpBrowser = $this->getModule('PhpBrowser');
        $phpBrowser->seeElement('//img[@src="'.$image_url.'"]', $data);
    }
}
