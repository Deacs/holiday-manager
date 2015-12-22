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
        $this->createSlug($model);
        $model->confirmation_token = str_random(32);
    }

    public function saved($model)
    {
        //$this->createSlug($model);
    }

    public function updating($model)
    {
        $this->createSlug($model);
    }

    /**
     * TODO
     * Use slugify as function
     */
    private function createSlug($model)
    {
        $model->slug = strtolower(join('-', [$model->first_name, $model->last_name]));
        $model->password = bcrypt($model->slug . microtime());
    }

}

