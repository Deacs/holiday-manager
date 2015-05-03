<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model {

    const PENDING_ID     = 1;
    const APPROVED_ID    = 2;
    const DECLINED_ID    = 3;
    const ACTIVE_ID      = 4;
    const CANCELLED_ID   = 5;
    const COMPLETED_ID   = 6;

    protected $table = 'status';

    protected $fillable = [
        'title'
    ];

    // Relationships

    public function holidayRequests()
    {
        return $this->belongsToMany('App\HolidayRequest');
    }

}
