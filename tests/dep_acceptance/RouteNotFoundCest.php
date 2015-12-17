<?php
use \AcceptanceTester;

class RouteNotFoundCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
     * @group redirects
     */
    public function see404PageWhenAttemptingToLoadUnfoundRoute(AcceptanceTester $I)
    {
        $I->am('General user');
        $I->amOnPage('/dont-exist');
        $I->see('Page not found', 'h1');
    }
}
