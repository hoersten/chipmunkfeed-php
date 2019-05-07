<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\City;
use App\Models\County;
use App\Models\Description;
use App\Models\State;

class CountyTest extends TestCase {
  use DatabaseMigrations;
  /**
  * Test county page has title.
  *
  * @return void
  */
  public function test_it_has_proper_title() {
    $county = factory(County::class)->create();
    $response = $this->get(route('counties.show', [ 'county' => $county ]));
    $response->assertOk();
    $string = "<h1>\s*$county->name\s*<\/h1>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test county page has state.
  *
  * @return void
  */
  public function test_it_has_state() {
    $county = factory(County::class)->create();
    $state = $county->state;
    $response = $this->get(route('counties.show', [ 'county' => $county ]));
    $response->assertOk();
    $string = "<strong>State:<\/strong>\\s*<a href=\"" . str_replace('/', '\/', route('states.show', $state)) . "\">$state->name<\/a>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test county page has county seat.
  *
  * @return void
  */
  public function test_it_has_county_seat() {
    $county = factory(County::class)->create();
    $capital = factory(City::class)->create(['state_id' => $county->state->id]);
    $this->linkCitiesAndCounty($capital, $county, 1);
    $response = $this->get(route('counties.show', [ 'county' => $county ]));
    $response->assertOk();
    $string = "<strong>\s*$county->county_type Seat:\s*<\/strong>\\s*<a href=\"" . str_replace('/', '\/', route('cities.show', [ 'state' => '', 'city' => $capital ])) . "\">$capital->name<\/a>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test county page has area.
  *
  * @return void
  */
  public function test_it_has_area() {
    $county = factory(County::class)->create();
    $response = $this->get(route('counties.show', [ 'county' => $county ]));
    $response->assertOk();
    $string = "<strong>Area:<\/strong>\s*" . number_format($county->area) . " mi<sup>2<\/sup>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test county page has population.
  *
  * @return void
  */
  public function test_it_has_population() {
    $county = factory(County::class)->create();
    $response = $this->get(route('counties.show', [ 'county' => $county ]));
    $response->assertOk();
    $string = "<strong>Population:<\/strong>\s*" . number_format($county->population);
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test county page has no population.
  *
  * @return void
  */
  public function test_it_has_no_population() {
    $county = factory(County::class)->create(['population' => null]);
    $response = $this->get(route('counties.show', [ 'county' => $county ]));
    $response->assertOk();
    $response->assertDontSee('<strong>Population:</strong>');
  }

  /**
  * Test county page has counties.
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
    $response = $this->get(route('counties.show', [ 'county' => $county ]));
    $response->assertOk();
    $string = "<strong>Cities:<\/strong>\\s*<a href=\"" . str_replace('/', '\/', route('counties.show', [ 'county' => $county ])) . "\/cities\">4 Cities<\/a>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test county page has no counties.
  *
  * @return void
  */
  public function test_it_has_no_cities() {
    $county = factory(County::class)->create();
    $response = $this->get(route('counties.show', [ 'county' => $county ]));
    $response->assertOk();
    $string = "<strong>Cities:<\/strong>\\s*<a href=\"" . str_replace('/', '\/', route('counties.show', [ 'county' => $county ])) . "\/cities\">0 Cities<\/a>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test county page has Web links.
  *
  * @return void
  */
  public function test_it_has_web_links() {
    $county = factory(County::class)->create();
    $response = $this->get(route('counties.show', [ 'county' => $county ]));
    $response->assertOk();
    $response->assertSee("<a href=\"$county->wikipedia\" target=\"_blank\">Wikipedia</a>");
    $response->assertSee("<a href=\"$county->twitter\" target=\"_blank\">Twitter</a>");
    $response->assertSee("<a href=\"$county->url\" target=\"_blank\">Official Homepage</a>");
  }

  /**
  * Test county page is missing Web links.
  *
  * @return void
  */
  public function test_it_missing_web_links() {
    $county = factory(County::class)->create(['wikipedia' => null, 'url' => null]);
    $response = $this->get(route('counties.show', [ 'county' => $county ]));
    $response->assertOk();
    $response->assertDontSee(">Wikipedia</a>");
    $response->assertSee("<a href=\"$county->twitter\" target=\"_blank\">Twitter</a>");
    $response->assertDontSee(">Official Homepage</a>");
  }

  /**
  * Test county page has description.
  *
  * @return void
  */
  public function test_it_has_description() {
    $county = factory(County::class)->create();
    $description = factory(Description::class, 'county')->states('active')->create(['model_id' => $county->id ]);
    $response = $this->get(route('counties.show', [ 'county' => $county ]));
    $response->assertOk();
    $response->assertSee($description->description);
  }

  /**
  * Test county page doesn't have description.
  *
  * @return void
  */
  public function test_it_does_not_have_description() {
    $county = factory(County::class)->create();
    $description = factory(Description::class, 'county')->create(['model_id' => $county->id ]);
    $response = $this->get(route('counties.show', [ 'county' => $county ]));
    $response->assertOk();
    $response->assertDontSee($description->description);
  }
}
