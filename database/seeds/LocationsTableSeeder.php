<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class LocationsTableSeeder extends Seeder {

    public function run()
    {
        $locations = [
            ['Exeter', 'exeter', 'Innovation Centre, Rennes Drive, Exeter, EX4 4RN', 50.7381, -3.53062, '01392 241319'],
	        ['London', 'london', '62 Dean Street, London, W1D 4QF', 51.513, -0.132277, '0181 1234567'],
	        ['Edinburgh', 'edinburgh', 'Silicon Walk, 25 Greenside Ln, Edinburgh, EH1 3AA', 55.9571, -3.18488, '0111 1234567'],
	        ['Manchester', 'manchester', 'Coronation Street, Manchester, MN12 123', 53.4617, -2.27171, '0122 1234567'],
	        ['Barcelona', 'barcelona', 'c/ Roselló 216, Planta 11, 08008, Barcelona, España', 40.4407, -3.67004, '+34 93 348 7322'],
        ];

        foreach ($locations as $location) {

            DB::table('locations')->insert([
                'name'          => $location[0],
                'slug'          => $location[1],
                'address'       => $location[2],
                'lat'           => $location[3],
                'lon'           => $location[4],
                'telephone'     => $location[5],
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);
        }
    }

}
