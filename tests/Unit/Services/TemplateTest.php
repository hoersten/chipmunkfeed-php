<?php

namespace Tests\Unit\Services;

use App\Models\City;
use App\Models\County;
use App\Models\Description;
use App\Models\State;
use App\Models\Template;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @coversDefaultClass App\Services\Template
 */
class TemplateServiceTest extends TestCase {
  use DatabaseMigrations;
  /**
   * @test
   * @covers ::buildStateDescription
   *
   * @return void
   */
  public function it_returns_builds_a_state_description() {
    $template = factory(Template::class, 'state')->states('active')->create(['template' => 'Welcome to {% name %} population {% population %}']);
    $state = factory(State::class)->create();
    $service = new \App\Services\Template();
    $service->buildStateDescription($state, $template);
    $this->assertEquals($state->description()->description, "Welcome to $state->name population $state->population");
  }

  /**
   * @test
   * @covers ::buildStateDescription
   *
   * @return void
   */
  public function it_returns_builds_a_state_description_with_missing_or_invalid_parameters() {
    $template = factory(Template::class, 'state')->states('active')->create(['template' => 'Welcome to {% name %} population {% population %}, and {% missing %} {% broken_link']);
    $state = factory(State::class)->create();
    $service = new \App\Services\Template();
    $service->buildStateDescription($state, $template);
    $this->assertEquals($state->description()->description, "Welcome to $state->name population $state->population, and  {% broken_link");
  }

  /**
   * @test
   * @covers ::buildCityDescription
   *
   * @return void
   */
  public function it_returns_builds_a_city_description() {
    $template = factory(Template::class, 'city')->states('active')->create(['template' => 'Welcome to {% name %} population {% population %}']);
    $city = factory(City::class)->create();
    $service = new \App\Services\Template();
    $service->buildCityDescription($city, $template);
    $this->assertEquals($city->description()->description, "Welcome to $city->name population $city->population");
  }

  /**
   * @test
   * @covers ::buildCityDescription
   *
   * @return void
   */
  public function it_returns_builds_a_city_description_with_missing_or_invalid_parameters() {
    $template = factory(Template::class, 'city')->states('active')->create(['template' => 'Welcome to {% name %} population {% population %}, and {% missing %} {% broken_link']);
    $city = factory(City::class)->create();
    $service = new \App\Services\Template();
    $service->buildCityDescription($city, $template);
    $this->assertEquals($city->description()->description, "Welcome to $city->name population $city->population, and  {% broken_link");
  }

  /**
   * @test
   * @covers ::buildCountyDescription
   *
   * @return void
   */
  public function it_returns_builds_a_county_description() {
    $template = factory(Template::class, 'county')->states('active')->create(['template' => 'Welcome to {% name %} population {% population %}']);
    $county = factory(County::class)->create();
    $service = new \App\Services\Template();
    $service->buildCountyDescription($county, $template);
    $this->assertEquals($county->description()->description, "Welcome to $county->name population $county->population");
  }

  /**
   * @test
   * @covers ::buildCountyDescription
   *
   * @return void
   */
  public function it_returns_builds_a_county_description_with_missing_or_invalid_parameters() {
    $template = factory(Template::class, 'county')->states('active')->create(['template' => 'Welcome to {% name %} population {% population %}, and {% missing %} {% broken_link']);
    $county = factory(County::class)->create();
    $service = new \App\Services\Template();
    $service->buildCountyDescription($county, $template);
    $this->assertEquals($county->description()->description, "Welcome to $county->name population $county->population, and  {% broken_link");
  }

}
