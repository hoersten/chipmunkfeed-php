<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\City;
use App\Models\County;
use App\Models\State;

class CountyCitiesTest extends TestCase {
  use DatabaseMigrations;
  /**
  * Test county cities page has title.
  *
  * @return void
  */
  public function test_it_has_proper_title() {
    $county = factory(County::class)->create();
    $state = $county->state;
    $response = $this->get(route('cities.county_index', $county));
    $response->assertOk();
    $string = "<h1>\s*Cities in $county->name, $state->name\s*<\/h1>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test county cities page has cities.
  *
  * @return void
  */
  public function test_it_has_cities() {
    $county = factory(County::class)->create();
    $cities = factory(City::class, 4)->create(['state_id' => $county->state->id])->each(
      function($city) use ($county) {
        $this->linkCitiesAndCounty($city, $county);
      }
    );
    $response = $this->get(route('cities.county_index', $county));
    $response->assertOk();
    $string = '<h3>\\s*List of Cities\\s*<\\/h3>';
    $this->assertRegExp('/' . $string . '/', $response->getContent());
    foreach ($cities as $city) {
      $response->assertSee('<a href="' . route('cities.show', ['state' => $city->state, 'city' => $city]) . "\">$city->name</a>");
    }
  }
}
