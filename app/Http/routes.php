<?php

use App\User;
use Illuminate\Http\Request;

get('test', 'ManagerController@test');

get('test', ['middleware' => 'lead', function () {

	dd('Middleware Passed Test');
//	dd('Passed Middleware');
//	$user = Auth::loginUsingId(2);
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

Route::group(['prefix' => 'department', 'as' => 'department.'], function () {

	get('{slug}',
		[
			'as' => 'home',
			'uses' => 'DepartmentController@show'
		]
	);

	get('{slug}/manage',
		[
			'middleware' 	=> 'lead',
			'as' 			=> 'manage',
			'uses' 			=> 'DepartmentController@manage'
		]
	);
});

Route::group(['prefix' => 'member', 'as' => 'member.'], function () {

	get('{slug}',
		[
			'as' => 'home',
			'uses' => 'UserController@show'
		]
	);

	post('add',
		[
			'as' => 'add',
			'uses' => 'UserController@store'
		]
	);

	get('confirm/{token}',
		[
			'as' => 'confirm',
			'uses' => 'UserController@confirm'
		]
	);

	post('confirm',
		[
			'as' => 'complete-confirmation',
			'uses' => 'UserController@completeConfirmation'
		]
	);

});

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

/**
 * API : Powered by VueJS
 */
get('beta', function () {
	return view('beta');
});

Route::group(['prefix' => 'api', 'as' => 'api.'], function () {

	get('members/', function () {
		return User::all();
	});

	post('members', 'UserController@store');

	get('member/holiday-requests',
		[
			'as' 	=> 'member.holiday-requests',
			'uses' 	=> 'UserController@holidayRequests'
		]
	);

	post('holiday/request',
		[
			'as' 	=> 'holiday.request',
			'uses' 	=> 'HolidayRequestController@store'
		]
	);
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
