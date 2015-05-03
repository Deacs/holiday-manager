<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {

	protected $table = 'departments';

	protected $fillable = [
		'name',
		'location_id'
	];

	public function location()
	{
		return $this->belongsTo('location');
	}

	public function members()
	{
		return $this->hasMany('App\User');
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
}
