<?php
use App\Models\State;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(State::class, function (Faker\Generator $faker) {
  return [
    'slug' => function() {  },
    'name' => $faker->state,
    'abbreviation' => $faker->stateAbbr,
    'country' => $faker->countryCode,
    'state_id' => $faker->numberBetween(0, 58),
    'fips' => $faker->text(5),
    'wikipedia' => $faker->url,
    'twitter' => $faker->url,
    'url' => $faker->url,
    'population' => $faker->randomNumber,
    'area' => $faker->randomFloat(null, 0, 100000),
    'latitude' => $faker->latitude,
    'longitude' => $faker->longitude,
    'zoom' => $faker->numberBetween(0, 6),
  ];
});