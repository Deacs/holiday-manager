<?php 
$I = new AcceptanceTester($scenario);

$I->am('logged out user');
$I->wantTo('receive appropriate messages for failed login');
