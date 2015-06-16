<?php
namespace Codeception\Module;

use AcceptanceTester;
use App\HolidayRequest;
use Carbon\Carbon;
use UnitTester;

class UnitHelper extends \Codeception\Module
{
    /**
     * Create an unapproved holiday request
     *
     * @return static
     */
    public function addUnapprovedRequest()
    {
        $t1 = new Carbon('next monday');
        $t2 = new Carbon('next friday');

        HolidayRequest::create([
            'start_date'    => $t1->year((new Carbon())->year),
            'end_date'      => $t2->year((new Carbon())->year),
            'user_id'       => 123,
        ]);
    }

    // -- Utility Functions

    /**
     * Ensure the date set is valid
     * Date validation checks for a date in the future, that is not a weekend and is this year
     *
     * @return $this
     */
    private function makeValidStartDate()
    {
        // Ensure the weekend validation passes
        $dt = new Carbon('next monday');
        // Prevent validation failures when next Friday is actually the following year
        $dt->year((new Carbon())->year);

        return $dt;
    }

    private function makeValidEndDate()
    {
        // Ensure the weekend validation passes
        $dt = new Carbon('next friday');
        // Prevent validation failures when next Friday is actually the following year
        $dt->year((new Carbon())->year);

        return $dt;
    }

}
