<?php namespace App\Repositories;

use App\HolidayRequest;
use App\Status;

class HolidayRepository {

    /**
     * Return all Holiday Requests
     */
    public function getAllRequests()
    {
        return HolidayRequest::all();
    }
    /**
     * Return Holiday Requests with the provided User ID
     *
     * @return
     * @param $userId
     */
    public function getRequestsByUserId($userId)
    {
        return HolidayRequest::where('user_id', $userId)->get();
    }

    /**
     * Return Holiday Requests with the provided Status ID
     *
     * @return
     * @param $statusId
     */
    public function getRequestsByStatusId($statusId)
    {
        return HolidayRequest::where('status_id', $statusId)->get();
    }

    /**
     * Return Holiday Requests that have been approved by the specified User ID
     * @return
     * @param $userId
     */
    public function getRequestsApprovedByUserId($userId)
    {
        return HolidayRequest::where('status_id', Status::APPROVED_ID)->where('approved_by', $userId)->get();
    }
}

