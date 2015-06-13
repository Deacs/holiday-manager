<?php

namespace App\Http\Controllers;

use App\HolidayRequest;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HolidayRequestController extends Controller
{

    public function store(Request $request)
    {
        HolidayRequest::create([
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'user_id'       => Auth::user()->id,
        ]);

        return response()->json(['status' => 'placed']);
    }
}
