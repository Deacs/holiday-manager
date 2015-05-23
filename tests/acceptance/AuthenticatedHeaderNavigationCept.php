<?php
$I = new AcceptanceTester($scenario);

$I->am('an authenticated user');
$I->wantTo('perform actions and see result');

$I->amOnPage('/');

$I->see('Login');

//$I->click('Teams');
//$I->click('Exeter');
//$I->see('Engineering');
//$I->see('Legal');
//$I->see('Engineering');
//
//$I->click('Teams');
//$I->click('London');
//$I->see('Business Development');
//$I->see('Bonds');
//
//$I->click('Teams');
//$I->click('Edinburgh');
//$I->see('Gateway');
//
//// Check the Home link returns us correctly
//$I->see('Holiday Planner');
//$I->click('Holiday Planner');
//$I->canSeeCurrentUrlEquals('/');

