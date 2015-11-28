<?php  namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgChart extends Model {

    use FileUploadTrait;

    protected $table = 'org_charts';

    protected $baseDir = 'img/departments/org-charts';

    protected $thumbnail_width = 1000;

    protected $thumbnail_height;

    protected $retain_aspect_ratio = true;

    protected $fillable = [
        'department_id',
        'path',
        'thumbnail_path',
    ];

    public function department()
    {
        return $this->hasOne('App\Department');
    }

}
