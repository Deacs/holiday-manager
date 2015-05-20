<?php

use App\User;

Route::get('/', ['as' => 'home', 'uses' => 'ManagerController@index']);

Route::get('location/{id}',
	[
		'as' 	=> 'location.home',
		'uses' 	=> 'LocationController@show'
	]
);

Route::get('department/{id}',
	[
		'as' 	=> 'department.home',
		'uses' 	=> 'DepartmentController@show'
	]
);

Route::get('calendar', 'CalendarController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
