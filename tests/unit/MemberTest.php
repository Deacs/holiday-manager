<?php

use App\Department;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends CrowdcubeTester
{

    //protected $baseUrl = 'http://caliente.dev';

    /**
     * @test
     * @group unit
     */
    public function correctly_formatted_full_name_is_returned_from_first_and_last_name()
    {
        $user = new User();
        $user->first_name = 'Tom';
        $user->last_name = 'Collins';

        $fullName = $user->fullName();

        $this->assertEquals('Tom Collins', $fullName);
    }

    /**
     * @test
     * @group unit
     */
    public function returns_false_when_assessing_department_lead_status_on_regular_user()
    {
        $user = new User();
        $department = new Department();
        $user->id = 1;
        $department->lead_id = 2;

        $isDepartmentLead = $user->isDepartmentLead($department);

        $this->assertFalse($isDepartmentLead);
    }

    /**
     * @test
     * @group unit
     */
    public function returns_true_when_assessing_department_lead_status_on_department_lead()
    {
        $user = new User();
        $department = new Department();
        $user->id = 1;
        $department->lead_id = 1;

        $isDepartmentLead = $user->isDepartmentLead($department);

        $this->assertTrue($isDepartmentLead);
    }

    /**
     * @test
     * @group unit
     */
    public function correct_department_is_returned_for_department_lead()
    {
        $user = new User();
        $department =  new Department();

        $user->id = 1;
        $user->department = $department;
        $department->id = 1;
        $department->lead_id = $user->id;

        $leadDepartment = $user->leadDepartment();

        $this->assertEquals($department->id, $leadDepartment->id);
    }

}
