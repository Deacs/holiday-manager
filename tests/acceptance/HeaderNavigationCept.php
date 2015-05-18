<?php
$I = new AcceptanceTester($scenario);

$I->am('a staff member');
$I->wantTo('test the correct header navigation elements are available');

$I->amOnPage('/');
$I->see('Holiday Manager');

$I->see('Your Holiday');
$I->see('Manage Requests');

$I->click('Department');
$I->click('Exeter');
$I->see('Engineering');
$I->see('Legal');
$I->see('Engineering');

$I->click('Department');
$I->click('London');
$I->see('Business Development');
$I->see('Bonds');
