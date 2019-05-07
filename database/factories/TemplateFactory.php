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
use App\Models\Template;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Template::class, function (Faker\Generator $faker) {
  return [
    'template' => $faker->words(3, true) . '{% population %}' . $faker->words(2, true) . '{% name %}',
    'active' => false,
    'tag' => $faker->word,
  ];
});

$factory->state(Template::class, 'active', function() {
  return [
    "active" => true,
  ];
});

$factory->defineAs(Template::class, 'city', function (Faker\Generator $faker) use ($factory) {
  $follow = $factory->raw(Template::class);
  $extras = [
    'model_type' => City::class,
  ];
  return array_merge($follow, $extras);
});

$factory->defineAs(Template::class, 'county', function (Faker\Generator $faker) use ($factory) {
  $follow = $factory->raw(Template::class);
  $extras = [
    'model_type' => County::class,
  ];
  return array_merge($follow, $extras);
});

$factory->defineAs(Template::class, 'state', function (Faker\Generator $faker) use ($factory) {
  $follow = $factory->raw(Template::class);
  $extras = [
    'model_type' => State::class,
  ];
  return array_merge($follow, $extras);
});