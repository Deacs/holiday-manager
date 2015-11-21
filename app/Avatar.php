<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_avatars';

    protected $fillable = ['user_id', 'path', 'thumbnail_path'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
