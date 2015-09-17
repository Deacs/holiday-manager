<?php

class CrowdcubeTester extends TestCase {

    protected $fake;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate:reset');
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

//    public function __construct()
//    {
////        $this->fake = \Faker::create();
//    }
}
