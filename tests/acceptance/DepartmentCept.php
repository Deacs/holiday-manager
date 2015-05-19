<?php 
$I = new AcceptanceTester($scenario);
$I->am('a team member');
$I->wantTo('open a Department home page and see the correct data');

$I->amOnPage('/department/1');
$I->see('Engineering');
$I->see('Department Lead: David Ives');

$I->amOnPage('/department/4');
$I->see('Product');
$I->see('Department Lead: Thor Mitchell');

$I->amOnPage('department/10');
$I->see('Gateway');
$I->see('Department Lead: Michael Wilkinson');
