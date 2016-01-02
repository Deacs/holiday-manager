<?php

function flash($title = null, $message = null)
{
    $flash = app('App\Http\Flash');

    if (func_num_args() == 0) {
        return $flash;
    }

    return $flash->info($title, $message);
}

function errorOverlay($errors)
{
    return implode('|', $errors->all());
//    foreach($errors->all() as $error) {
//
//    }
//    return '<b>Attention</b> here we go!';
}
