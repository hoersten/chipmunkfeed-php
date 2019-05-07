<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
|
*/

use App\Models\County;
use App\Models\State;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(County::class, function (Faker\Generator $faker) {
  return [
    'state_id' => function() { return factory(State::class)->create()->id; },
    'slug' => function() { },
    'name' => $faker->word,
    'county_type' => $faker->randomElement(['Borough', 'Census Area', 'County', 'Parish']),
    'county_id' => $faker->numberBetween(0, 200),
    'fips' => $faker->text(5),
    'wikipedia' => $faker->url,
    'twitter' => $faker->url,
    'url' => $faker->url,
    'population' => $faker->randomNumber,
    'area' => $faker->randomFloat(null, 0, 100000),
    'latitude' => $faker->latitude,
    'longitude' => $faker->longitude,
  ];
});