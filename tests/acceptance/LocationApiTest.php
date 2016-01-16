<?php

use App\Department;
use App\Location;
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
        $location = factory(Location::class)->create();

        $this->get('/api'.$location->url)->seeJsonContains([
            'name'      => $location->name,
            'slug'      => Str::slug($location->name),
            'address'   => $location->address,
            'telephone' => $location->telephone,
            'lat'       => $location->lat,
            'lon'       => $location->lon,
        ]);
    }

    /**
     * @test
     */
    public function request_to_show_all_locations_returns_correct_location_names()
    {
        $locations = factory(Location::class, 5)->create();

        $this->get('/api/locations')->seeJsonContains([
            'name' => $locations[0]->name,
            'name' => $locations[1]->name,
            'name' => $locations[2]->name,
            'name' => $locations[3]->name,
            'name' => $locations[4]->name,
        ]);
    }

    /**
     * @test
     */
    public function request_to_show_departments_linked_to_specified_location_returns_correct_data()
    {
        $location       = factory(Location::class)->create(['id' => 1]);
        $departments    = factory(Department::class, 3)->create(['location_id' => $location->id]);

        $this->get('/api/locations/'.$location->slug.'/departments')
            ->seeJson([
                'name' => $departments[0]->name,
                'name' => $departments[1]->name,
                'name' => $departments[2]->name,
            ]);
    }

    /**
     * @test
     */
    public function request_to_show_departments_linked_to_specified_location_does_not_return_departments_from_another_location()
    {
        $locationOne = factory(Location::class)->create(['id' => 1]);
        $locationTwo = factory(Location::class)->create(['id' => 2]);

        $departments = factory(Department::class, 3)->create(['location_id' => $locationTwo->id]);

        $this->get('/api/locations/'.$locationOne->slug.'/departments')
            ->dontSeeJson([
                'name' => $departments[0]->name,
                'name' => $departments[1]->name,
                'name' => $departments[2]->name,
            ]);
    }

}
