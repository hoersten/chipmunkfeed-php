<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
|
*/

use App\Models\City;
use App\Models\County;
use App\Models\State;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(City::class, function (Faker\Generator $faker) {
  return [
    'state_id' => function() { return factory(State::class)->create()->id; },
    'slug' => function() { },
    'name' => $faker->city,
    'state_capital' => false,
    'gnis' => $faker->word,
    'fips' => $faker->text(5),
    'msa' => $faker->randomNumber(),
    'usa' => $faker->randomNumber(),
    'cbsa' => $faker->randomNumber(),
    'csa' => $faker->randomNumber(),
    'psa' => $faker->randomNumber(),
    'dma' => $faker->randomNumber(),
    'wikipedia' => $faker->url,
    'twitter' => $faker->url,
    'url' => $faker->url,
    'population' => $faker->randomNumber,
    'area' => $faker->randomFloat(null, 0, 100000),
    'latitude' => $faker->latitude,
    'longitude' => $faker->longitude,
  ];
});

$factory->state( City::class, 'state_capital', function() {
  return [
    "state_capital" => true,
  ];
});
