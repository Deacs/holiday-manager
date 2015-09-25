<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationApiTest extends CrowdcubeTester
{

    protected $baseUrl = 'http://caliente.dev';

    /**
     * @test
     */
    public function request_to_show_location_returns_correct_data()
    {
        $this->get('/api/locations/exeter')->seeJsonContains([
            'name'      => 'Exeter',
            'slug'      => 'exeter',
            'address'   => 'Innovation Centre, Rennes Drive, Exeter, EX4 4RN',
            'telephone' => '01392 241319',
            'lat'       => '50.7381',
            'lon'       => '-3.53062',
        ]);
    }

    /**
     * @test
     */
    public function request_to_show_all_locations_returns_correct_location_names()
    {
        $this->get('/api/locations')->seeJsonContains([
            'name' => 'Exeter',
            'name' => 'London',
            'name' => 'Manchester',
            'name' => 'Barcelona',
        ]);
    }

    /**
     * @test
     */
    public function request_to_show_departments_linked_to_specified_location_returns_correct_data()
    {
        $this->get('/api/locations/exeter/departments')->seeJson([
            'name' => 'Bonds',
            'name' => 'Completions',
            'name' => 'Engineering',
            'name' => 'Finance',
            'name' => 'Investments',
            'name' => 'Legal',
            'name' => 'Marketing',
        ]);
    }

    /**
     * @test
     */
    public function request_to_show_deaprtments_linked_to_specified_location_does_not_return_departments_from_another_location()
    {
        $this->get('/api/locations/exeter/departments')->dontSeeJson([
           'name' => 'Business Development'
        ]);
    }

}
