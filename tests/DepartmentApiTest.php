<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DepartmentApiTest extends CrowdcubeTester
{

//    use DatabaseMigrations;

    protected $baseUrl = 'http://caliente.dev';

    /**
     * @test
     */
    public function request_to_show_department_returns_correct_data()
    {
        Auth::loginUsingId(1);

        $this->get('/api/departments/engineering')->seeJsonContains([
            'name'          => 'Engineering',
            'slug'          => 'engineering',
            'lead_id'       => '1',
            'location_id'   => '1',
        ]);
    }

    /**
     * @test
     */
    public function request_to_show_all_departments_returns_correct_department_names()
    {
        Auth::loginUsingId(1);

        $this->get('/api/departments')->seeJson([
            'name' => 'Engineering',
            'name' => 'Marketing',
            'name' => 'Finance',
            'name' => 'Business Development',
            'name' => 'Product',
            'name' => 'Completions',
            'name' => 'Investments',
            'name' => 'Legal',
            'name' => 'Bonds',
        ]);
    }

}
