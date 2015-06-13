<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HolidayRequest extends Controller
{
    public function store(Request $request)
    {
        $holiday_request = new \App\HolidayRequest();

        // Get each date between the start and end date
        $start =  Carbon::createFromFormat('Y-m-d', ($request->start_date))->startOfDay();
        $end   = Carbon::createFromFormat('Y-m-d', ($request->end_date))->startOfDay();

        $holiday_request->setStartDate($request->start_date);
        $holiday_request->setEndDate($request->end_date);

        $holiday_request->user_id = 2;

        $holiday_request->save();

        // ------------------------------
        // Add a day to ensure we have all the days in the request
        echo $start->diffInDays($end->copy()->addDay()) . ' days in request';
        // ------------------------------

        var_dump($start);
        var_dump($end);
        die();
    }
}
