<?php  namespace App;

use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OrgChart extends Model {

    protected $table = 'org_charts';

    protected $fillable = [
        'department_id',
        'path',
        'thumbnail_path',
    ];

    protected $name;

    protected $baseDir = 'img/departments/org-charts';

    public function department()
    {
        return $this->hasOne('App\Department');
    }

    /**
     * Take an uploaded file and associate it with the item
     *
     * @param UploadedFile $file
     * @param string $slug
     */
    public static function fromFile(UploadedFile $file, $slug)
    {
        return (new static)->saveAs($slug, $file->getClientOriginalExtension());
    }

    /**
     * Set all of the required values for the new file
     *
     * @param $slug
     * @param $extension
     * @return $this
     */
    public function saveAs($slug, $extension)
    {
        $this->name             = time() . '-' .$slug . '.' . $extension;
        $this->path             = sprintf("%s/%s", $this->baseDir, $this->name);
        $this->thumbnail_path   = sprintf("%s/tn-%s", $this->baseDir, $this->name);

        return $this;
    }

    /**
     * Save the file to the FS
     *
     * @param UploadedFile $file
     * @return $this
     */
    public function store(UploadedFile $file)
    {
        $file->move($this->baseDir, $this->name);

        $this->makeThumbnail();

        return $this;
    }

    public function makeThumbnail()
    {
        Image::make($this->path)
            ->fit(200)
            ->save($this->thumbnail_path);
    }

}
