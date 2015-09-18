<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationTest extends CrowdcubeTester
{

    protected $baseUrl = 'http://caliente.dev';

    /**
     * @test
     */
    public function request_to_show_location_returns_correct_data()
    {
        Auth::loginUsingId(1);

        $this->call('GET', '/api/locations/exeter');

        $this->assertResponseOk();
        $this->get('/api/locations/exeter')->seeJsonContains([
            'name' => 'Exeter',
            'slug' => 'exeter',
        ]);
    }
}
