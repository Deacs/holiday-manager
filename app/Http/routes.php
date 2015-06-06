<?php

get('test', 'ManagerController@test');

get('test', ['middleware' => 'lead', function () {

	dd('Middleware Passed Test');
//	dd('Passed Middleware');
//	$user = Auth::loginUsingId(2);
//
//	dd($user);
}]);

get('/', ['as' => 'home', 'uses' => 'ManagerController@index']);

get('calendar', 'CalendarController@index');

get('directory',
	[
		'as' 	=> 'directory.home',
		'uses' 	=> 'StaffDirectoryController@index'
	]
);

get('location/{slug}',
	[
		'as' 	=> 'location.home',
		'uses' 	=> 'LocationController@show'
	]
);

get('department/{slug}',
	[
		'as' 	=> 'department.home',
		'uses' 	=> 'DepartmentController@show'
	]
);

get('member/{slug}',
	[
		'as' 	=> 'member.home',
		'uses' 	=> 'UserController@show'
	]
);

post('member/add',
	[
		'as' 	=> 'member.add',
		'uses' 	=> 'UserController@store'
	]
);

get('member/confirm/{token}',
	[
		'as' 	=> 'member.confirm',
		'uses' 	=> 'UserController@confirm'
	]
);

post('member/confirm',
	[
		'as' 	=> 'member.complete-confirmation',
		'uses' 	=> 'UserController@completeConfirmation'
	]
);

get('login',
	[
		'as' 	=> 'login.home',
		'uses' 	=> 'LoginController@index'
	]
);

post('login',
	[
		'as' 	=> 'login.attempt',
		'uses' 	=> 'LoginController@authenticate'
	]
);

get('logout',
	[
		'as' 	=> 'logout',
		'uses' 	=> 'LoginController@logout'
	]
);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
