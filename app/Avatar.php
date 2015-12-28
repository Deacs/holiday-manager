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

    protected $thumbnail_width = 200;

    protected $thumbnail_height = 200;

    protected $retain_aspect_ratio = false;

    protected $fillable = ['user_id', 'path', 'thumbnail_path'];

    protected $baseDir = 'img/users/avatars';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The img directory name cannot begin with a slash
     * Ensure the returned string has the required formatting
     *
     * @return string
     */
    public function formattedPath()
    {
        return strpos($this->thumbnail_path, '/', 0) ? '/' . $this->thumbnail_path : $this->thumbnail_path;
    }

}
