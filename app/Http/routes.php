<?php

//Route::get('/', 'WelcomeController@index');
Route::get('/', ['as' => 'home', 'uses' => 'ManagerController@index']);

//Route::get('home', 'HomeController@index');

Route::get('calendar', 'CalendarController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
