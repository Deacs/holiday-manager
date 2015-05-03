<?php namespace App\Repositories;

use App\HolidayRequest;

class HolidayRepository {

    public function getRequestsByUserId($userId)
    {
        return HolidayRequest::where('user_id', $userId)->get();
    }

    public function getRequestsByStatusId($statusId)
    {
        return HolidayRequest::where('status_id', $statusId)->get();
    }
}

