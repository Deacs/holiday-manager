<?php
$I = new AcceptanceTester($scenario);

$I->am('a staff member');
$I->wantTo('test the correct header navigation elements are available');

$I->amOnPage('/');
$I->see('Holiday Manager');

$I->see('Login');
$I->click('Login');
$I->canSeeCurrentUrlEquals('/login');

$I->see('Your Holiday');
$I->see('Manage Requests');

$I->click('Teams');
$I->click('Exeter');
$I->see('Engineering');
$I->see('Legal');
$I->see('Engineering');

$I->click('Teams');
$I->click('London');
$I->see('Business Development');
$I->see('Bonds');

$I->click('Teams');
$I->click('Edinburgh');
$I->see('Gateway');

// Check the Home link returns us correctly
$I->see('Holiday Planner');
$I->click('Holiday Planner');
$I->canSeeCurrentUrlEquals('/');

