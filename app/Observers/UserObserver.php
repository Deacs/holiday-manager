<?php namespace App\Observers;

class UserObserver {

    /**
     * Certain fields need to be automatically generated when creating a user
     * - slug
     * - password
     * - confirmation_token
     *
     * @param $model
     */
    public function creating($model)
    {
        $model->slug = strtolower(join('-', [$model->first_name, $model->last_name]));
        $model->password = bcrypt($model->slug.microtime());
        $model->confirmation_token = str_random(32);
    }

    public function saved($model)
    {
    }

}

