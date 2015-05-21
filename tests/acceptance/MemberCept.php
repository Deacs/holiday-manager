<?php

$I = new AcceptanceTester($scenario);

$I->am('a member');
$I->wantTo('view my own page and view the correct data');

$I->amOnPage('/member/tom-leigh');
$I->see('Tom Leigh');

$I->see('Holiday Status');
$I->see('Not currently on leave');

$I->see('No approved holiday requests');

$I->see('Approve');
