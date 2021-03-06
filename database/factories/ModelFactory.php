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

$factory->define(App\User::class, function ($faker) {
    return [
        'username' => $faker->lastName,
        'avatar_url' => $faker->imageUrl($width=200, $height=200, 'people', true, 'Faker'),
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Template::class, function ($faker) {
    return [
        'name' => $faker->sentence, 
        'price' => 20, 
        'price_multiple' => 200,
        'price_extended' => 400,
        'version' => 1.0,
        'description' => $faker->text,
        'screenshot' => $faker->imageUrl($width=1100, $height=590, 'nature', true, 'Faker'),
        'preview_url' => $faker->url,
        'files_url' => $faker->url,
        'layout' => 'Responsive',
        'frameworks' => 'Bootstrap',
        'preprocessor' => 'Sass',
        'browser' => 'Chrome, Firefox, Safari, Opera, IE11, IE10, IE9, IE8',
        'columns' => '3',
        'exclusive' => false,
        'files_included' => 'Lorem, ipsum, dolor, sit, amet',
        'approved'  => true
    ];
});


