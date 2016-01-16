<?php

use App\User;
use Carbon\Carbon;
use App\Department;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DepartmentApiTest extends CrowdcubeTester
{

    use DatabaseTransactions;

    protected $baseUrl = 'http://caliente.dev';

    /**
     * @test
     */
    public function request_to_show_department_returns_correct_data()
    {
        $department = $this->createDepartmentAndLead();

        $this->createUserAndLogin();

        $this->get('/api'.$department->url)->seeJsonContains([
            'name'          => $department->name,
            'slug'          => $department->slug,
            'lead_id'       => $department->lead_id,
            'location_id'   => $department->location_id,
        ]);
    }

    /**
     * @test
     */
    public function request_to_show_all_departments_returns_correct_department_names()
    {
        $departments = factory(Department::class, 5)->create();

        $this->createUserAndLogin();

        $this->get('/api/departments')->seeJson([
            'name' => $departments[0]->name,
            'name' => $departments[1]->name,
            'name' => $departments[2]->name,
            'name' => $departments[3]->name,
            'name' => $departments[4]->name,
        ]);
    }

}
