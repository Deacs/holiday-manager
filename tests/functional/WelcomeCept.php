<?php 
$I = new FunctionalTester($scenario);

$I->am('a staff member');
$I->wantTo('test the DB is set up correctly');

$I->amOnPage('/');

$I->seeInDatabase('users', ['id' => 1, 'first_name' => 'David']);


