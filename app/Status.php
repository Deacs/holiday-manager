<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model {

    const PENDING_STATUS_ID     = 1;
    const APPROVED_STATUS_ID    = 2;
    const DECLINED_STATUS_ID    = 3;
    const ACTIVE_STATUS_ID      = 4;
    const CANCELLED_STATUS_ID   = 5;
    const COMPLETED_STATUS_ID   = 6;

}
