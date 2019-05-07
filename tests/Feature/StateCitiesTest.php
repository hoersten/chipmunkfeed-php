<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\City;
use App\Models\County;
use App\Models\State;

class StateCitiesTest extends TestCase {
  use DatabaseMigrations;
  /**
  * Test state page has title.
  *
  * @return void
  */
  public function test_it_has_proper_title() {
    $state = factory(State::class)->create();
    $capital = factory(City::class)->state('state_capital')->create(['state_id' => $state->id]);
    $response = $this->get(route('cities.state_index', $state));
    $response->assertOk();
    $string = "<h1>\s*Cities in $state->name\s*<\/h1>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test state page has cities.
  *
  * @return void
  */
  public function test_it_has_cities() {
    $state = factory(State::class)->create();
    $capital = factory(City::class)->state('state_capital')->create(['state_id' => $state->id]);
    $cities = factory(City::class, 4)->create(['state_id' => $state->id]);
    $response = $this->get(route('cities.state_index', $state));
    $response->assertOk();
    $string = '<h3>\\s*List of Cities\\s*<\\/h3>';
    $this->assertRegExp('/' . $string . '/', $response->getContent());
    foreach ($cities as $city) {
      $response->assertSee('<a href="' . route('cities.show', ['state' => '', 'city' => $city]) . "\">$city->name</a>");
    }
  }
}
