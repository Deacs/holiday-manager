<?php

$factory('App\User', [
    'first_name'                => $faker->,
    'last_name'                 => $faker->,
    'email'                     => $faker->email,
    'telephone'                 => $faker->,
    'department_id'             => 'factory:App\Department',
    'location_id'               => 'factory:App\Location',
    'password'                  => $faker->password,
    'annual_holiday_allowance'  =>
]);

$factory('App\Department', [
    'name'          => '',
    'location_id'   => 'factory:App\Location'
]);

$factory('App\Location', [
    'name'      => '',
    'telephone' => ''
]);

$factory('App\HolidayRequest', [
    'user_id'       => 'factory:App\User',
    'date'          => ,
    'status_id'     => 'factory:App\Status',
    'approved_by'   => 'factory:App\User',
    'declined_by'   => 'factory:App\User'
]);

$factory('App\Status', [
    'name' => '',
]);
