<?php

use App\Location;

class LocationUnitTest extends CrowdcubeTester
{

    /**
     * @test
     * @group unit
     */
    public function returns_correctly_formatted_url()
    {
        $slug = 'my-location';

        $location = new Location();

        $location->slug = $slug;

        $this->assertEquals('/locations/'.$slug, $location->getUrlAttribute());
    }
}
