<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\City;
use App\Models\County;
use App\Models\Description;
use App\Models\State;

class CityTest extends TestCase {
  use DatabaseMigrations;
  /**
  * Test city page has title.
  *
  * @return void
  */
  public function test_it_has_proper_title() {
    $city = factory(City::class)->create();
    $response = $this->get(route('cities.show', [ 'state' => '', 'city' => $city ]));
    $response->assertOk();
    $string = "<h1>\s*$city->name\s*<\/h1>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test city page has state.
  *
  * @return void
  */
  public function test_it_has_state() {
    $city = factory(City::class)->create();
    $state = $city->state;
    $response = $this->get(route('cities.show', [ 'state' => '', 'city' => $city ]));
    $response->assertOk();
    $string = "<strong>State:<\/strong>\\s*<a href=\"" . str_replace('/', '\/', route('states.show', $state)) . "\">$state->name<\/a>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test city page has state capital.
  *
  * @return void
  */
  public function test_it_has_state_capital() {
    $city = factory(City::class)->state('state_capital')->create();
    $state = $city->state;
    $response = $this->get(route('cities.show', [ 'state' => '', 'city' => $city ]));
    $response->assertOk();
    $string = "<strong>State:<\/strong>\\s*<a href=\"" . str_replace('/', '\/', route('states.show', $state)) . "\">$state->name<\/a>\s*\(State capital\)";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test city page has county.
  *
  * @return void
  */
  public function test_it_has_county_capital() {
    $city = factory(City::class)->create();
    $county = factory(County::class)->create(['state_id' => $city->state->id]);
    $this->linkCitiesAndCounty($city, $county);
    $response = $this->get(route('cities.show', [ 'state' => '', 'city' => $city ]));
    $response->assertOk();
    $string = "<strong>\s*Primary $county->county_type:\s*<\/strong>\\s*<a href=\"" . str_replace('/', '\/', route('counties.show', [ 'county' => $county ])) . "\">$county->name<\/a>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test city page has county capital.
  *
  * @return void
  */
  public function test_it_has_primary_county() {
    $city = factory(City::class)->create();
    $county = factory(County::class)->create(['state_id' => $city->state->id]);
    $this->linkCitiesAndCounty($city, $county, 1);
    $response = $this->get(route('cities.show', [ 'state' => '', 'city' => $city ]));
    $response->assertOk();
    $string = "<strong>\s*Primary $county->county_type:\s*<\/strong>\\s*<a href=\"" . str_replace('/', '\/', route('counties.show', [ 'county' => $county ])) . "\">$county->name<\/a>\s*\($county->county_type capital\)";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test city page has area.
  *
  * @return void
  */
  public function test_it_has_area() {
    $city = factory(City::class)->create();
    $response = $this->get(route('cities.show', [ 'state' => '', 'city' => $city ]));
    $response->assertOk();
    $string = "<strong>Area:<\/strong>\s*" . number_format($city->area) . " mi<sup>2<\/sup>";
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test city page has population.
  *
  * @return void
  */
  public function test_it_has_population() {
    $city = factory(City::class)->create();
    $response = $this->get(route('cities.show', [ 'state' => '', 'city' => $city ]));
    $response->assertOk();
    $string = "<strong>Population:<\/strong>\s*" . number_format($city->population);
    $this->assertRegExp('/' . $string . '/', $response->getContent());
  }

  /**
  * Test city page has no population.
  *
  * @return void
  */
  public function test_it_has_no_population() {
    $city = factory(City::class)->create(['population' => null]);
    $response = $this->get(route('cities.show', [ 'state' => '', 'city' => $city ]));
    $response->assertOk();
    $response->assertDontSee('<strong>Population:</strong>');
  }

  /**
  * Test city page has other counties.
  *
  * @return void
  */
  public function test_it_has_other_counties() {
    $city = factory(City::class)->create();
    factory(County::class, 2)->create(['state_id' => $city->state->id])->each(
      function($county) use ($city) {
        $this->linkCitiesAndCounty($city, $county);
      }
    );
    $response = $this->get(route('cities.show', [ 'state' => '', 'city' => $city ]));
    $response->assertOk();
    $countyType = $city->counties()->first()->county_type;
    foreach ($city->counties as $county) {
      if ($county->id == $city->counties()->first()->id) {
        $string = "<strong>\s*Primary $countyType:\s*<\/strong>\\s*<a href=\"" . str_replace('/', '\/', route('counties.show', [ 'county' => $county ])) . "\">$county->name<\/a>";
      } else {
        $string = "<strong>\s*Other $countyType:\s*<\/strong>\\s*<a href=\"" . str_replace('/', '\/', route('counties.show', [ 'county' => $county ])) . "\">$county->name<\/a>";
      }
      $this->assertRegExp('/' . $string . '/', $response->getContent());
    }
  }

  /**
  * Test city page has no counties.
  *
  * @return void
  */
  public function test_it_has_no_counties() {
    $city = factory(City::class)->create();
    $response = $this->get(route('cities.show', [ 'state' => '', 'city' => $city ]));
    $response->assertOk();
    $response->assertDontSee('Primary');
  }

  /**
  * Test city page has Web links.
  *
  * @return void
  */
  public function test_it_has_web_links() {
    $city = factory(City::class)->create();
    $response = $this->get(route('cities.show', [ 'state' => '', 'city' => $city ]));
    $response->assertOk();
    $response->assertSee("<a href=\"$city->wikipedia\" target=\"_blank\">Wikipedia</a>");
    $response->assertSee("<a href=\"$city->twitter\" target=\"_blank\">Twitter</a>");
    $response->assertSee("<a href=\"$city->url\" target=\"_blank\">Official Homepage</a>");
  }

  /**
  * Test city page is missing Web links.
  *
  * @return void
  */
  public function test_it_missing_web_links() {
    $city = factory(City::class)->create(['wikipedia' => null, 'url' => null]);
    $response = $this->get(route('cities.show', [ 'state' => '', 'city' => $city ]));
    $response->assertOk();
    $response->assertDontSee(">Wikipedia</a>");
    $response->assertSee("<a href=\"$city->twitter\" target=\"_blank\">Twitter</a>");
    $response->assertDontSee(">Official Homepage</a>");
  }

  /**
  * Test city page has description.
  *
  * @return void
  */
  public function test_it_has_description() {
    $city = factory(City::class)->create();
    $description = factory(Description::class, 'city')->states('active')->create(['model_id' => $city->id ]);
    $response = $this->get(route('cities.show', [ 'state' => '', 'city' => $city ]));
    $response->assertOk();
    $response->assertSee($description->description);
  }

  /**
  * Test city page doesn't have description.
  *
  * @return void
  */
  public function test_it_does_not_have_description() {
    $city = factory(City::class)->create();
    $description = factory(Description::class, 'city')->create(['model_id' => $city->id ]);
    $response = $this->get(route('cities.show', [ 'state' => '', 'city' => $city ]));
    $response->assertOk();
    $response->assertDontSee($description->description);
  }
}
