<?php

$factory('App\Status', [
    'title' => $faker->word,
]);

$factory('App\User', [
    'first_name'                => $faker->firstNameMale,
    'last_name'                 => $faker->lastName,
    'role'                      => $faker->word,
    'password'                  => $faker->word,
    'email'                     => $faker->email,
    'telephone'                 => $faker->phoneNumber,
    'extension'                 => $faker->phoneNumber,
    'skype_name'                => 'crowdcube.'.$faker->firstNameMale,
    'department_id'             => 'factory:App\Department',
    'location_id'               => 'factory:App\Location',
    'super_user'                => 0,
    'annual_holiday_allowance'  => 25,
    'confirmed'                 => 1
]);

$factory('App\User', 'super_user', [
    'first_name'                => $faker->firstNameMale,
    'last_name'                 => $faker->lastName,
    'role'                      => $faker->word,
    'password'                  => $faker->word,
    'email'                     => $faker->email,
    'telephone'                 => $faker->phoneNumber,
    'extension'                 => $faker->phoneNumber,
    'skype_name'                => 'crowdcube.'.$faker->firstNameMale,
    'department_id'             => 'factory:App\Department',
    'location_id'               => 'factory:App\Location',
    'super_user'                => 1,
    'annual_holiday_allowance'  => 25,
    'confirmed'                 => 1
]);

$factory('App\User', 'new_user', [
    'first_name'                => $faker->firstNameMale,
    'last_name'                 => $faker->lastName,
    'role'                      => $faker->word,
    'password'                  => $faker->word,
    'email'                     => $faker->email,
    'telephone'                 => $faker->phoneNumber,
    'extension'                 => $faker->phoneNumber,
    'skype_name'                => 'crowdcube.'.$faker->firstNameMale,
    'department_id'             => 'factory:App\Department',
    'location_id'               => 'factory:App\Location',
    'super_user'                => 1,
    'annual_holiday_allowance'  => 25,
    'confirmed'                 => 0,
    'confirmation_token'        => $faker->randomElement(32)
]);

$factory('App\Department', [
    'name'      => $faker->word,
    'lead_id'   => 1
]);

$factory('App\Location', [
    'name'      => $faker->word,
    'address'   => $faker->address,
    'telephone' => $faker->phoneNumber
]);

