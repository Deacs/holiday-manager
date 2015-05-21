<?php

use App\User;

Route::get('test', function () {
	$user = Auth::loginUsingId(2);

	dd($user);
});

Route::get('/', ['as' => 'home', 'uses' => 'ManagerController@index']);

Route::get('location/{slug}',
	[
		'as' 	=> 'location.home',
		'uses' 	=> 'LocationController@show'
	]
);

Route::get('department/{slug}',
	[
		'as' 	=> 'department.home',
		'uses' 	=> 'DepartmentController@show'
	]
);

Route::get('member/{slug}',
	[
		'as' 	=> 'member.home',
		'uses' 	=> 'UserController@show'
	]
);

Route::get('calendar', 'CalendarController@index');

Route::get('login',
	[
		'as' 	=>'login',
		'uses' 	=> 'LoginController@index'
	]
);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
