<?php namespace App\Http\Controllers;

use App\HolidayRequest;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HolidayRequestController extends Controller
{

    public function store(Request $request)
    {
        $holiday_request = HolidayRequest::create([
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'user_id'       => Auth::user()->id,
        ]);

        if ( ! $holiday_request) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Holiday Request could not be placed'
            ], 404);
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Holiday Request successfully placed'
        ]);
    }
}
