<?php 
$I = new AcceptanceTester($scenario);
$I->am('a team member');
$I->wantTo('visit the Location home page and see the correct data');

$I->amOnPage('/location/1');
$I->see('Exeter');
$I->see('Innovation Centre');
$I->see('01392 241319');
