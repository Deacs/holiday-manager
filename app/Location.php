<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

	protected $table = 'locations';

    protected $fillable = [
        'name',
        'telephone'
    ];

    public function departments()
    {
        return $this->hasMany('departments');
    }

}
