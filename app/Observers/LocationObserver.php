<?php namespace App\Observers;

class LocationObserver {

    /**
     * Slug needs to be automatically generated when creating a location
     *
     * @param $model
     */
    public function creating($model)
    {
        $model->slug = strtolower(str_replace(' ', '-', $model->name));
    }

}

