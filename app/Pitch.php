<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Pitch extends Model {

    protected $table = 'crowdcube_pitches';

    protected $appends = [
        'url',
        'objectId',
        'overfunding',
        'progress'
    ];

    protected $fillable = [];

    public function logo()
    {
        return $this->hasOne('App\CompanyLogo', 'item_id');
    }

    public function getObjectIDAttribute()
    {
        return 'pitch_'.$this->id;
    }

    public function getOverfundingAttribute()
    {
        return ($this->progress_procent >= 100) ? 'true' : 'false';
    }

    public function getProgressAttribute()
    {
        return $this->progress_procent;
    }

    public function getUrlAttribute()
    {
        return 'https://www.crowdcube.com/investment/'.str_replace(' ', '-', $this->title).'-'.$this->id;
    }

    public function companyLogoPath()
    {
        if (is_null($this->logo)) {
            return 'placeholder.jpg';
        }

        return 'https://images.crowdcube.com/unsafe/fit-in/300x300/filters:fill(fff)/https://files-crowdcube-com.s3.amazonaws.com/files/pitch_pics/original/'.$this->logo->file_path;
    }
}

