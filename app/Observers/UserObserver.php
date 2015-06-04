<?php namespace App\Observers;

class UserObserver {

    /**
     * Generate a slug and a password for a new user
     * @TODO A 'confirmed' field needs to be added to the model
     */
    public function creating($model)
    {
        $model->slug = strtolower(join('-', [$model->first_name, $model->last_name]));
        $model->password = bcrypt($model->slug.microtime());
    }

    public function saved($model)
    {
    }

}

