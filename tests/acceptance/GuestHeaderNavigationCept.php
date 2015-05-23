<?php

$I = new AcceptanceTester($scenario);

$I->am('a staff member');
$I->wantTo('test the correct header navigation elements are available');

$I->amOnPage('/');
$I->see('Holiday Manager');

$I->see('Login');
$I->click('Login');
$I->canSeeCurrentUrlEquals('/login');
