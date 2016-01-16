<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Status::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'first_name'                => $faker->firstNameMale,
        'last_name'                 => $faker->lastName,
        'role'                      => $faker->word,
        'password'                  => Hash::make($faker->word),
        'email'                     => $faker->email,
        'telephone'                 => $faker->phoneNumber,
        'extension'                 => $faker->phoneNumber,
        'skype_name'                => 'crowdcube.'.$faker->firstNameMale,
        'department_id'             => factory(App\Department::class)->create()->id,
        'location_id'               => factory(App\Location::class)->create()->id,
        'super_user'                => 0,
        'confirmed'                 => 1
    ];
});

$factory->defineAs(App\User::class, 'new_user', function (Faker\Generator $faker) {
    return [
        'first_name'                => $faker->firstNameMale,
        'last_name'                 => $faker->lastName,
        'role'                      => $faker->word,
        'password'                  => $faker->word,
        'email'                     => $faker->email,
        'telephone'                 => $faker->phoneNumber,
        'extension'                 => $faker->phoneNumber,
        'skype_name'                => 'company.'.$faker->firstNameMale,
        'department_id'             => factory(App\Department::class)->create()->id,
        'location_id'               => factory(App\Location::class)->create()->id,
        'super_user'                => 1,
        'confirmed'                 => 0,
        'confirmation_token'        => $faker->randomElement(32)
    ];
});

$factory->define(App\Department::class, function (Faker\Generator $faker) {
    return [
        'name'          => $faker->word,
        'lead_id'       => 1,
        'location_id'   => factory(App\Location::class)->create()->id,
    ];
});

$factory->define(App\Location::class, function (Faker\Generator $faker) {
    return [
        'name'      => $faker->word,
        'address'   => $faker->address,
        'telephone' => $faker->phoneNumber,
        'lat'       => $faker->latitude,
        'lon'       => $faker->longitude
    ];
});

$factory->define(App\Avatar::class, function (Faker\Generator $faker) {
    return [
        'user_id'   => factory(App\User::class)->create()->id,
        'path'      => file($sourceDir = '/img/users/avatars', $targetDir = 'img/users/avatars')
    ];
});

$factory->define(App\OrgChart::class, function (Faker\Generator $faker) {
    return [
        'department_id' => factory(App\Department::class)->create()->id,
        'path'          => file($sourceDir = '/tmp', $targetDir = '/tmp')
    ];
});
