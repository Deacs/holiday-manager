<?php

use \App\Department as Department;

class DepartmentTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    public function test_fetches_departments()
    {
        Department::create(['name' => 'Engineering', 'location_id' => 1]);
        Department::create(['name' => 'Finance', 'location_id' => 1]);
        Department::create(['name' => 'Business Developemnt', 'location_id' => 2]);

        $departments = Department::exeter()->get();

        $this->assertCount(2, $departments);
    }

}
