<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class DepartmentsTableSeeder extends Seeder {

    public function run()
    {
        $departments = [
            ['Engineering', 'engineering', 1, 1],
	        ['Marketing', 'marketing', 4, 1],
	        ['Investments', 'investments', 13, 1],
	        ['Product', 'product', 14, 1],
	        ['Completions', 'completions', 7, 1],
	        ['Finance', 'finance', 7, 1],
	        ['Legal', 'legal', 11, 1],
	        ['Bonds', 'bonds', 12, 2],
	        ['Business Development', 'business-development', 9, 2],
	        ['Gateway', 'gateway', 13, 3],
        ];

        foreach ($departments as $department) {

            DB::table('departments')->insert([
                'name'          => $department[0],
                'slug'          => $department[1],
                'lead_id'       => $department[2],
                'location_id'   => $department[3],
            ]);
        }
    }

}
