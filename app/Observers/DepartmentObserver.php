<?php namespace App\Observers;

use Illuminate\Support\Str;

class DepartmentObserver {

    /**
     * Slug needs to be automatically generated when creating a department
     *
     * @param $model
     */
    public function creating($model)
    {
        $model->slug = Str::slug($model->name);

        // TODO
        // Email the designated lead to inform them that the Department has been created
    }

}
