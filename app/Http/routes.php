<?php

Route::get('/', ['as' => 'home', 'uses' => 'ManagerController@index']);

Route::get('department/{id}', ['as' => 'department_home', 'uses' => 'DepartmentController@show']);

Route::get('calendar', 'CalendarController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
