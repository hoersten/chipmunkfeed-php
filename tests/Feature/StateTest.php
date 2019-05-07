<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\City;
use App\Models\County;
use App\Models\Description;
use App\Models\State;

class StateTest extends TestCase {
  use DatabaseMigrations;
  /**
  * Test state page has title.
  *
  * @return void
  */
  public function test_it_has_proper_title() {
    $state = factory(State::class)->create();
    $capital = factory(City::class)->state('state_capital')->create(['state_id' => $state->id]);
    $response = $this->get(route('states.show', $state));
    $response->assertOk();
    $response->assertSee("<h1>$state->name</h1>");
  }

  /**
  * Test state page has capital.
  *
  * @return void
  */
  public function test_it_has_capital() {
    $state = factory(State::class)->create();
    $capital = factory(City::class)->state('state_capital')->create(['state_id' => $state->id]);
    $response = $this->get(route('states.show', $state));
    $response->assertOk();
    $string = "<strong>Capital:<\/strong>\\s*<a href=\"" . str_replace('/', '\/', route('cities.show', [ 'state' => '', 'county' => $capital ])) . "\">$capital->name<\/a>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test state page has abbreviation.
  *
  * @return void
  */
  public function test_it_has_abbreviation() {
    $state = factory(State::class)->create();
    $capital = factory(City::class)->state('state_capital')->create(['state_id' => $state->id]);
    $response = $this->get(route('states.show', $state));
    $response->assertOk();
    $string = "<strong>Abbreviation:<\/strong>\\s*$state->abbreviation";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test state page has population.
  *
  * @return void
  */
  public function test_it_has_population() {
    $state = factory(State::class)->create();
    $capital = factory(City::class)->state('state_capital')->create(['state_id' => $state->id]);
    $response = $this->get(route('states.show', $state));
    $response->assertOk();
    $string = "<strong>Population:<\/strong>\\s*" . number_format($state->population);
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test state page has no population.
  *
  * @return void
  */
  public function test_it_has_no_population() {
    $state = factory(State::class)->create(['population' => null]);
    $capital = factory(City::class)->state('state_capital')->create(['state_id' => $state->id]);
    $response = $this->get(route('states.show', $state));
    $response->assertOk();
    $response->assertDontSee('<strong>Population:</strong>');
  }

  /**
  * Test state page has counties.
  *
  * @return void
  */
  public function test_it_has_counties() {
    $state = factory(State::class)->create();
    $capital = factory(City::class)->state('state_capital')->create(['state_id' => $state->id]);
    $counties = factory(County::class, 4)->create(['state_id' => $state->id]);
    $response = $this->get(route('states.show', $state));
    $response->assertOk();
    $string = "<strong>Counties:<\/strong>\\s*<a href=\"" . str_replace('/', '\\/', route('counties.index', $state)) . "\">4 Counties<\/a>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test state page has no counties.
  *
  * @return void
  */
  public function test_it_has_no_counties() {
    $state = factory(State::class)->create(['population' => null]);
    $capital = factory(City::class)->state('state_capital')->create(['state_id' => $state->id]);
    $response = $this->get(route('states.show', $state));
    $response->assertOk();
    $string = "<strong>Counties:<\/strong>\\s*<a href=\"" . str_replace('/', '\\/', route('counties.index', $state)) . "\">0 Counties<\/a>";
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
    $response = $this->get(route('states.show', $state));
    $response->assertOk();
    $string = "<strong>Cities:<\/strong>\\s*<a href=\"" . str_replace('/', '\\/', route('cities.state_index', $state)) . "\">5 Cities<\/a>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test state page has Web links.
  *
  * @return void
  */
  public function test_it_has_web_links() {
    $state = factory(State::class)->create();
    $capital = factory(City::class)->state('state_capital')->create(['state_id' => $state->id]);
    $response = $this->get(route('states.show', $state));
    $response->assertOk();
    $response->assertSee("<a href=\"$state->wikipedia\" target=\"_blank\">Wikipedia</a>");
    $response->assertSee("<a href=\"$state->twitter\" target=\"_blank\">Twitter</a>");
    $response->assertSee("<a href=\"$state->url\" target=\"_blank\">Official Homepage</a>");
  }

  /**
  * Test state page is missing Web links.
  *
  * @return void
  */
  public function test_it_missing_web_links() {
    $state = factory(State::class)->create(['wikipedia' => null, 'url' => null]);
    $capital = factory(City::class)->state('state_capital')->create(['state_id' => $state->id]);
    $response = $this->get(route('states.show', $state));
    $response->assertOk();
    $response->assertDontSee(">Wikipedia</a>");
    $response->assertSee("<a href=\"$state->twitter\" target=\"_blank\">Twitter</a>");
    $response->assertDontSee(">Official Homepage</a>");
  }

  /**
  * Test state page has description.
  *
  * @return void
  */
  public function test_it_has_description() {
    $state = factory(State::class)->create();
    $capital = factory(City::class)->state('state_capital')->create(['state_id' => $state->id]);
    $description = factory(Description::class, 'state')->states('active')->create(['model_id' => $state->id ]);
    $response = $this->get(route('states.show', $state));
    $response->assertOk();
    $response->assertSee($description->description);
  }

  /**
  * Test state page doesn't have description.
  *
  * @return void
  */
  public function test_it_does_not_have_description() {
    $state = factory(State::class)->create();
    $capital = factory(City::class)->state('state_capital')->create(['state_id' => $state->id]);
    $description = factory(Description::class, 'state')->create(['model_id' => $state->id ]);
    $response = $this->get(route('states.show', $state));
    $response->assertOk();
    $response->assertDontSee($description->description);
  }
}
