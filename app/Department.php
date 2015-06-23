<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Location as Location;

class Department extends Model {

	protected $table = 'departments';

	protected $appends = [
		'url'
	];

	protected $fillable = [
		'name',
		'slug',
		'location_id'
	];

	const ENGINEERING 			= 1;
	const MARKETING 			= 2;
	const INVESTMENTS 			= 3;
	const PRODUCT 				= 4;
	const COMPLETIONS 			= 5;
	const FINANCE 				= 6;
	const LEGAL 				= 7;
	const BONDS 				= 8;
	const BUSINESS_DEVELOPMENT 	= 9;

	public function location()
	{
		return $this->belongsTo('App\Location');
	}

	public function team()
	{
		return $this->hasMany('App\User');
	}

	public function lead()
	{
		return $this->hasOne('App\User', 'id', 'lead_id');
	}

	public function scopeExeter($query)
	{
		return $query->where('location_id', Location::EXETER_ID);
	}

	public function scopeLondon($query)
	{
		return $query->where('location_id', Location::LONDON_ID);
	}

	public function scopeScotland($query)
	{
		return $query->where('location_id', Location::SCOTLAND_ID);
	}

	public function scopeManchester($query)
	{
		return $query->where('location_id', Location::MANCHESTER_ID);
	}

	public function scopeBarcelona($query)
	{
		return $query->where('location_id', Location::BARCELONA_ID);
	}

	public function getUrlAttribute()
	{
		return '/department/'.$this->slug;
	}
}
