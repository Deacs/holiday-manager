<?php
$I = new AcceptanceTester($scenario);

$I->am('a staff member');
$I->wantTo('test the correct navigation elements are available');

$I->amOnPage('/');
$I->see('Holiday Manager');
//$I->seeInDatabase('users', ['id' => 1, 'first_name' => 'David']);
