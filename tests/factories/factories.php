<?php

$factory('App\Status', [
    'title' => $faker->word,
]);

$factory('App\User', [
    'first_name'                => $faker->firstNameMale,
    'last_name'                 => $faker->lastName,
    'email'                     => $faker->email,
    'telephone'                 => $faker->phoneNumber,
    'department_id'             => 'factory:App\Department',
    'location_id'               => 'factory:App\Location',
    'lead'                      => 0,
    'super_user'                => 0,
    'annual_holiday_allowance'  => 25
]);

$factory('App\User', 'lead_user', [
    'first_name'                => $faker->firstNameMale,
    'last_name'                 => $faker->lastName,
    'email'                     => $faker->email,
    'telephone'                 => $faker->phoneNumber,
    'department_id'             => 'factory:App\Department',
    'location_id'               => 'factory:App\Location',
    'lead'                      => 1,
    'super_user'                => 0,
    'annual_holiday_allowance'  => 25
]);

$factory('App\User', 'super_user', [
    'first_name'                => $faker->firstNameMale,
    'last_name'                 => $faker->lastName,
    'email'                     => $faker->email,
    'telephone'                 => $faker->phoneNumber,
    'department_id'             => 'factory:App\Department',
    'location_id'               => 'factory:App\Location',
    'lead'                      => 0,
    'super_user'                => 1,
    'annual_holiday_allowance'  => 25
]);

$factory('App\Department', [
    'name' => $faker->word
]);

$factory('App\Location', [
    'name'      => $faker->word,
    'address'   => $faker->address,
    'telephone' => $faker->phoneNumber
]);

$factory('App\HolidayRequest', [
    'user_id'       => 'factory:App\User',
    'request_date'  => $faker->dateTime,
    'status_id'     => \App\Status::PENDING_ID, // This needs checking - it doesn't feel right
    'approved_by'   => 'factory:App\User',
    'declined_by'   => 'factory:App\User'
]);
