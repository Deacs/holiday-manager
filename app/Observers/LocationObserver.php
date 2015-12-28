<?php namespace App\Observers;

use Illuminate\Support\Str;

class LocationObserver {

    /**
     * Slug needs to be automatically generated when creating a location
     *
     * @param $model
     */
    public function creating($model)
    {
        $model->slug = Str::slug($model->name);
    }

}

