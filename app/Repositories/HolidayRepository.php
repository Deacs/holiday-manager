<?php namespace App\Repositories;

use App\HolidayRequest;
use App\Status;

class
HolidayRepository {

    /**
     * Return all Holiday Requests
     *
     * @return HolidayRequest | null
     */
    public function getAllRequests()
    {
        return HolidayRequest::all();
    }
    /**
     * Return Holiday Requests with the provided User ID
     *
     * @return HolidayRequest | null
     * @param $userId
     */
    public function getRequestsByUserId($userId)
    {
        return HolidayRequest::where('user_id', $userId)->get();
    }

    /**
     * Return Holiday Requests with the provided Status ID
     *
     * @return HolidayRequest | null
     * @param $statusId
     */
    public function getRequestsByStatusId($statusId)
    {
        return HolidayRequest::where('status_id', $statusId)->get();
    }

    /**
     * Return Holiday Requests that have been approved by the specified User ID
     *
     * @return HolidayRequest | null
     * @param $userId
     */
    public function getRequestsApprovedByUserId($userId)
    {
        return HolidayRequest::where('status_id', Status::APPROVED_ID)->where('approved_by', $userId)->get();
    }

    /**
     * Return Holiday Requests submitted by users belonging to the specified Department ID
     *
     * @return HolidayRequest | null
     * @param $departmentId
     */
    public function getRequestsByDepartmentId($departmentId)
    {
        return HolidayRequest::leftJoin('users', 'users.id', '=', 'holiday_requests.user_id')
                ->where('users.department_id', $departmentId)
                ->get();
    }

    public function getRequestsInSpecifiedYear($year)
    {
        return HolidayRequest::where( \DB::raw("strftime('%Y',request_date)"), '=', $year )->get();
    }
}

