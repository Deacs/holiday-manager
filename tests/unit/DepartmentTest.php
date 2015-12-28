<?php

use App\User;
use App\OrgChart;
use App\Department;
use Illuminate\Support\Str;

class DepartmentUnitTest extends CrowdcubeTester
{

    /**
     * @test
     * @group unit
     */
    public function no_test()
    {
        $this->assertEquals(1,1);
    }

    /**
     * @test
     * @group unit
     */
    public function correctly_formatted_url_returned_from_get_url_attribute()
    {
        $department = new Department();

        $departmentName = 'My Department';
        $department->name = $departmentName;

        $department->slug = Str::slug($departmentName);

        $this->assertEquals('/departments/my-department', $department->getUrlAttribute());
    }

    /**
     * @test
     * @group unit
     */
    public function returns_false_when_checking_for_org_chart_when_none_has_been_created()
    {
        $department = new Department();

        $this->assertFalse($department->hasOrgChart());
    }

    /**
     * @test
     * @group unit
     */
    public function correct_path_is_returned_when_requesting_org_chart()
    {
        $department = new Department();

        $department->id = 1;
        $path = 'path/to/chart.jpg';

        $orgChart = new OrgChart();
        $orgChart->department_id = $department->id;
        $orgChart->path = $path;
        $orgChart->thumbnail_path = $path;

        $orgChart->save();

        $this->assertEquals($path, $department->getOrgChart()->path);
    }

    /**
     * @test
     * @group unit
     */
    public function correct_user_id_is_returned_when_requesting_lead()
    {
        $department = new Department();
        $user = new User();
        $user->id = 4;

        $department->lead_id = $user->id;

        $this->assertEquals(4, $department->lead->id);
    }
}
