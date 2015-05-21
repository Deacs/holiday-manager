<?php 
$I = new AcceptanceTester($scenario);
$I->am('a team member');
$I->wantTo('open a Department home page and see the correct data');

$I->amOnPage('/department/engineering');
$I->see('Engineering');
$I->see('Department Lead: David Ives');

$I->see('Team Members');
$I->see('Rob Crowe');
$I->click('Rob Crowe', '.member-link');
$I->canSeeCurrentUrlEquals('/member/rob-crowe');

$I->amOnPage('/department/product');
$I->see('Product');
$I->see('Department Lead: Thor Mitchell');
$I->dontSee('No team members associated with Product');

$I->amOnPage('department/gateway');
$I->see('Gateway');
$I->see('Department Lead: Michael Wilkinson');
$I->see('No team members associated with Gateway');
