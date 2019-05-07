<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\County;
use App\Models\State;

class StateCountiesTest extends TestCase {
  use DatabaseMigrations;
  /**
  * Test state page has title.
  *
  * @return void
  */
  public function test_it_has_proper_title() {
    $state = factory(State::class)->create();
    $counties = factory(County::class)->create(['state_id' => $state->id]);
    $response = $this->get(route('counties.index', $state));
    $response->assertOk();
    $string = "<h1>\s*Counties in $state->name\s*<\/h1>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test state page has counties.
  *
  * @return void
  */
  public function test_it_has_counties() {
    $state = factory(State::class)->create();
    $counties = factory(County::class, 4)->create(['state_id' => $state->id]);
    $response = $this->get(route('counties.index', $state));
    $response->assertOk();
    $string = '<h3>\\s*List of Counties\\s*<\\/h3>';
    $this->assertRegExp('/' . $string . '/', $response->getContent());
    foreach ($counties as $county) {
      $response->assertSee('<a href="' . route('counties.show', [ 'county' => $county]) . "\">$county->name</a>");
    }
  }
}
