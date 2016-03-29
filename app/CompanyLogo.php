<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyLogo extends Model {

    protected $table = 'crowdcube_pitches_1_pic_en';

    protected $appends = [];

    protected $fillable = [];

    public function pitch()
    {
        return $this->belongsTo('App\Pitch', 'item_id');
    }

    public function getThumbPathAttribute()
    {
        return 'https://images.crowdcube.com/unsafe/fit-in/300x300/filters:fill(fff)/https://files-crowdcube-com.s3.amazonaws.com/files/pitch_pics/original/'.$this->file_path;
    }
}


