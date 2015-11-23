<?php  namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgChart extends Model {

    use FileUploadTrait;

    protected $table = 'org_charts';

    protected $fillable = [
        'department_id',
        'path',
        'thumbnail_path',
    ];

//    protected $name;

    protected $baseDir = 'img/departments/org-charts';

    public function department()
    {
        return $this->hasOne('App\Department');
    }

}
