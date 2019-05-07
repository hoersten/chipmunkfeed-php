<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\State;

class StateIndexTest extends TestCase {
  use DatabaseMigrations;
  /**
  * Test state index page has title.
  *
  * @return void
  */
  public function test_it_has_proper_title() {
    $states = factory(State::class, 5)->create();
    $response = $this->get(route('states.index'));
    $response->assertOk();
    $string = "<h1>\s*States\s*<\/h1>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test state page has capital.
  *
  * @return void
  */
  public function test_it_has_list_of_states() {
    $states = factory(State::class, 5)->create();
    $response = $this->get(route('states.index'));
    $response->assertOk();
    foreach ($states as $state) {
      $response->assertSee('<a href="' . route('states.show', $state) . "\">$state->name</a>");
    }
  }
}
