<?php 
$I = new AcceptanceTester($scenario);
$I->am('a team member');
$I->wantTo('open a Department home page and see the correct data');

$I->amOnPage('/department/1');
$I->see('Engineering');
