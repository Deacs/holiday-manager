<?php 
$I = new AcceptanceTester($scenario);
$I->am('a team member');
$I->wantTo('visit the Location home page and see the correct data');

$I->amOnPage('/locations/exeter');
$I->see('Exeter');
$I->see('Innovation Centre');
$I->see('01392 241319');

$I->seeElement('.department-link');

$I->see('Engineering', '.department-link');
$I->click('Engineering');
$I->canSeeCurrentUrlEquals('/departments/engineering');
