<?php

use App\User;
use Illuminate\Http\Request;

Route::group(['middleware' => 'auth'], function() {

	get('/',
		[
			'as' 	=> 'home',
			'uses' 	=> 'ManagerController@index'
		]
	);

	get('directory',
		[
			'as' 	=> 'directory.home',
			'uses' 	=> 'StaffDirectoryController@index'
		]
	);
});

/**
 * Session handling
 */
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

Route::group(['middleware' => 'auth', 'prefix' => 'member', 'as' => 'member.'], function () {

	get('{slug}',
		[
			'as' 	=> 'home',
			'uses' 	=> 'UserController@show'
		]
	);

	get('{slug}/edit',
		[
			'as' 	=> 'edit',
			'uses' 	=> 'UserController@edit',
		]
	);

	post('{slug}/edit',
		[
			'as' 	=> 'edit',
			'uses' 	=> 'UserController@update',
		]
	);

	post('add',
		[
			'as' 	=> 'add',
			'uses' 	=> 'UserController@store'
		]
	);

	get('confirm/{token}',
		[
			'as' 	=> 'confirm',
			'uses'	=> 'UserController@confirm'
		]
	);

	post('confirm',
		[
			'as' 	=> 'complete-confirmation',
			'uses' 	=> 'UserController@completeConfirmation'
		]
	);

	post('{id}/avatar',
		[
			'as' 	=> 'avatar-upload',
			'uses' 	=> 'UserController@uploadAvatar'
		]
	);
});

Route::group(['middleware' => 'auth', 'prefix' => 'locations', 'as' => 'location.'], function () {

	get('add',
		[
			'middleware'	=> 'superuser',
			'as' 			=> 'location.create',
			'uses' 			=> 'LocationController@create',
		]
	);

	post('add',
		[
			'middleware'	=> 'superuser',
			'as' 			=> 'add',
			'uses' 			=> 'LocationController@store',
		]
	);

	get('{slug}',
		[
			'as' 	=> 'home',
			'uses' 	=> 'LocationController@show'
		]
	);
});

Route::group(['middleware' => 'auth', 'prefix' => 'departments', 'as' => 'department.'], function () {

	get('/',
		[
			'as' 	=> 'index',
			'uses' 	=> 'DepartmentController@index'
		]
	);

	get('add',
		[
			'as' 	=> 'department.create',
			'uses' 	=> 'DepartmentController@create'
		]
	);

	get('{slug}',
		[
			'as' 	=> 'home',
			'uses' 	=> 'DepartmentController@show'
		]
	);

	get('{slug}/manage',
		[
			'middleware' 	=> 'lead',
			'as' 			=> 'manage',
			'uses' 			=> 'DepartmentController@manage'
		]
	);

	post('{slug}/org-chart',
		[
			'as' 	=> 'update-org-chart',
			'uses' 	=> 'DepartmentController@addOrgChart',
		]
	);
});

/**
 * API : Powered by VueJS
 */
get('beta', function () {
	return view('beta');
});

Route::group(['prefix' => 'api', 'as' => 'api.'], function () {

	get('locations/{slug}/departments/teams',
		[
			'as' 	=> 'location.department.teams',
			'uses' 	=> 'LocationController@departmentTeams'
		]
	);

	get('locations/{slug}/members',
		[
			'as' 	=> 'location.members',
			'uses' 	=> 'LocationController@members'
		]
	);

	get('locations/{slug}/departments',
		[
			'as' 	=> 'location.departments',
			'uses' 	=> 'LocationController@departments'
		]
	);

	get('locations/{slug}',
		[
			'as' 	=> 'locations',
			'uses'	=> 'LocationController@profile'
		]
	);

	get('locations',
		[
			'as' 	=> 'locations',
			'uses'	=> 'LocationController@index'
		]
	);

	get('departments/{slug}/team',
		[
			'as' 	=> 'department.team',
			'uses' 	=> 'DepartmentController@team'
		]
	);

	get('departments/{slug}',
		[
			'as' 	=> 'department.show',
			'uses' 	=> 'DepartmentController@profile'
		]
	);

	get('departments',
		[
			'as' 	=> 'departments',
			'uses' 	=> 'DepartmentController@listing'
		]
	);

	get('member/{slug}',
		[
			'as' 	=> 'member.show',
			'uses' 	=> 'UserController@profile',
		]
	);

	get('member/{user_slug}/can-edit/{member_slug}',
		[
			'as' 	=> 'member.can-edit',
			'uses' 	=> 'UserController@canEditMember'
		]
	);

	get('members',
		[
			'as' 	=> 'members',
			'uses' 	=> 'UserController@index'
		]
	);

	post('member/add',
		[
			'as' 	=> 'member.add',
			'uses' 	=> 'UserController@store'
		]
	);

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
	'auth' 		=> 'Auth\AuthController',
	'password' 	=> 'Auth\PasswordController',
]);
