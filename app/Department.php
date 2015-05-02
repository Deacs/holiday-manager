<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {

	protected $table = 'departments';

	protected $fillable = [
		'name',
		'location_id'
	];

	const EXETER_ID = 1;
	const LONDON_ID = 2;

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
		return $query->where('location_id', static::EXETER_ID);
	}

	public function london()
	{
		return [];
	}

}
