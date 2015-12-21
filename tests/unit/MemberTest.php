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
        $department->id = 1;
        $user->department = $department;
        $department->lead_id = $user->id;

        $leadDepartment = $user->leadDepartment();

        $this->assertEquals($department->id, $leadDepartment->id);
    }

    /**
     * @test
     * @group unit
     */
    public function false_is_returned_when_requesting_lead_department_for_standard_user()
    {
        $user = new User();
        $department = new Department();
        $user_department = new Department();

        $user->id = 1;
        $department->id = 1;
        $user_department->id = 2;
        $user->department = $user_department;

    }

    /**
     * @test
     * @group unit
     */
    public function returns_false_when_checking_super_user_status_for_non_super_user()
    {
        $user = new User();
        $user->super_user = 0;

        $this->assertFalse($user->isSuperUser());
    }

    /**
     * @test
     * @group unit
     */
    public function returns_true_when_checking_super_user_status_for_super_user()
    {
        $user = new User();
        $user->super_user = 1;

        $this->assertTrue($user->isSuperUser());
    }

    /**
     * @test
     * @group unit
     */
    public function returns_false_when_checking_edit_user_permissions_on_standard_user_against_other_member()
    {
        $user = new User();
        $user->id = 1;

        $department = new Department();
        $department->lead_id = 2;

        $member = new User();
        $member->id = 3;
        $member->department = $department;

        $this->assertFalse($user->hasEditUserPermissions($member));
    }

    /**
     * @test
     * @group unit
     */
    public function returns_true_when_checking_edit_user_permissions_on_department_lead_against_other_member_from_that_department()
    {
        $user = new User();
        $user->id = 1;

        $department = new Department();
        $department->lead_id = 1;

        $member = new User();
        $member->id = 2;
        $member->department = $department;

        $this->assertTrue($user->hasEditUserPermissions($member));
    }

    /**
     * @test
     * @group unit
     */
    public function returns_false_when_checking_edit_user_permissions_on_department_lead_against_other_member_from_different_department()
    {
        $user = new User();
        $user->id = 1;

        $department = new Department();
        $department->lead_id = 1;

        $memberDepartment = new Department();
        $member = new User();
        $member->id = 2;
        $member->department = $memberDepartment;

        $this->assertFalse($user->hasEditUserPermissions($member));
    }

    /**
     * @test
     * @group unit
     */
    public function returns_true_when_checking_edit_user_permissions_on_own_account()
    {
        $user = new User();
        $user->id = 1;

//        $department = new Department();
        $user->department = (new Department);
        $member = $user;

        $this->assertFalse($user->hasEditUserPermissions($member));
    }

}
