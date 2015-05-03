<?php

use \App\Department as Department;
use Laracasts\TestDummy\Factory;

class DepartmentTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    public function test_basic_example()
    {
        $department = Factory::create('App\HolidayRequest');

        dd($department->toArray());
    }

//    public function test_fetches_departments()
//    {
////        var_dump($this->app['config']['database']);
////        echo getenv('DB_DEFAULT');
//
//        Department::create(['name' => 'Engineering', 'location_id' => 1]);
//        Department::create(['name' => 'Finance', 'location_id' => 1]);
//        Department::create(['name' => 'Business Development', 'location_id' => 2]);
//
//        $departments = Department::exeter()->get();
//
//        $this->assertCount(2, $departments);
//    }

}
