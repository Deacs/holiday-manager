<?php

use App\Avatar;

class AvatarUnitTest extends CrowdcubeTester
{

    /**
     * @test
     * @group unit
     */
    public function correctly_formatted_path_returned_when_no_preceding_slash_in_stored_path()
    {
        $path = 'path/to/thumb.jpg';

        $avatar = new Avatar();

        $avatar->thumbnail_path = $path;

        $this->assertEquals('/'.$path, $avatar->formattedPath());
    }

    /**
     * @test
     * @group unit
     */
    public function correctly_formatted_path_returned_when_preceding_slash_in_stored_path()
    {
        $path = '/path/to/thumb.jpg';

        $avatar = new Avatar();

        $avatar->thumbnail_path = $path;

        $this->assertEquals($path, $avatar->formattedPath());
    }

}
