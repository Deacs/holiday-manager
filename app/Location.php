<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

	protected $table = 'locations';

    protected $appends = ['url'];

    protected $fillable = [
        'name',
        'slug',
        'telephone',
        'address',
        'lat',
        'lon'
    ];

    const EXETER_ID 	= 1;
    const LONDON_ID 	= 2;
    const SCOTLAND_ID 	= 3;
    const MANCHESTER_ID = 4;
    const BARCELONA_ID 	= 5;

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function departments()
    {
        return $this->hasMany('App\Department');
    }

    public function formattedAddress()
    {
        return str_replace(',', '<br />', $this->address);
    }

    public function getUrlAttribute()
    {
        return '/locations/'.$this->slug;
    }

}
