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
use App\Models\Description;
use App\Models\State;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Description::class, function (Faker\Generator $faker) {
  return [
    'description' => $faker->paragraphs(3, true),
    'active' => false,
    'tag' => $faker->word,
  ];
});

$factory->state(Description::class, 'active', function() {
  return [
    "active" => true,
  ];
});

$factory->defineAs(Description::class, 'city', function (Faker\Generator $faker) use ($factory) {
  $follow = $factory->raw(Description::class);
  $city = factory(City::class)->create();
  $extras = [
    'model_id'   => function() { return factory(City::class)->create()->id; },
    'model_type' => City::class,
  ];
  return array_merge($follow, $extras);
});

$factory->defineAs(Description::class, 'county', function (Faker\Generator $faker) use ($factory) {
  $follow = $factory->raw(Description::class);
  $extras = [
    'model_id'   => function() { return factory(County::class)->create()->id; },
    'model_type' => County::class,
  ];
  return array_merge($follow, $extras);
});

$factory->defineAs(Description::class, 'state', function (Faker\Generator $faker) use ($factory) {
  $follow = $factory->raw(Description::class);
  $extras = [
    'model_id'   => function() { return factory(State::class)->create()->id; },
    'model_type' => State::class,
  ];
  return array_merge($follow, $extras);
});