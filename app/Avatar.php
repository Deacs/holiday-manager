<?php namespace App;

use Illuminate\Database\Eloquent\Model;


class Avatar extends Model
{
    use FileUploadTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_avatars';

    protected $fillable = ['user_id', 'path', 'thumbnail_path'];

    protected $baseDir = 'img/users/avatars';

    protected $name;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
