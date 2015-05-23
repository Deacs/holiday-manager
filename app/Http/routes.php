<?php

//Auth::loginUsingId(1);

//Route::get('test', 'ManagerController@test');

Route::get('test', ['middleware' => 'lead', function () {

	dd('Middleware Passed Test');
//	dd('Passed Middleware');
//	$user = Auth::loginUsingId(2);
//
//	dd($user);
}]);

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
		'as' 	=> 'login.home',
		'uses' 	=> 'LoginController@index'
	]
);

Route::post('login',
	[
		'as' 	=> 'login.attempt',
		'uses' 	=> 'LoginController@authenticate'
	]
);

Route::get('logout',
	[
		'as' 	=> 'logout',
		'uses' 	=> 'LoginController@logout'
	]
);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
