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

}
