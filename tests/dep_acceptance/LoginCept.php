<?php 
$I = new AcceptanceTester($scenario);

$I->am('an anonymous user');
$I->wantTo('open the login page and see the login form');

$I->amOnPage('/login');
$I->see('Login');

$I->see('email Address');
$I->see('Password');
$I->see('Remember Me');

