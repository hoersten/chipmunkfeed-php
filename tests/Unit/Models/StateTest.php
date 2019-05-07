<?php

namespace Tests\Unit\Models;

use App\Models\City;
use App\Models\County;
use App\Models\Description;
use App\Models\State;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @coversDefaultClass App\Models\State
 */
class StateModelTest extends TestCase {
  use DatabaseMigrations;
  /**
   * @test
   * @covers ::capital
   *
   * @return void
   */
  public function it_returns_empty_capital() {
    $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
    $state = factory(State::class)->create();
    $state->capital;
  }

  /**
   * @test
   * @covers ::capital
   *
   * @return void
   */
  public function it_returns_existing_capital() {
    $city = factory(City::class)->states('state_capital')->create();
    $this->assertEquals($city->id, $city->state->capital()->id);
  }

  /**
   * @test
   * @covers ::cities
   *
   * @return void
   */
  public function it_returns_empty_cities() {
    $state = factory(State::class)->create();
    $this->assertCount(0, $state->cities);
  }

  /**
   * @test
   * @covers ::cities
   *
   * @return void
   */
  public function it_returns_valid_cities() {
    factory(City::class, 3)->create();
    $state = factory(State::class)->create();
    factory(City::class, 2)->create(['state_id' => $state->id]);
    $cities = $state->cities;
    $this->assertCount(2, $cities);
    $name = '';
    foreach($cities as $city) {
      $this->assertEquals($city->state_id, $state->id);
      $this->assertLessThanOrEqual($city->name, $name);
      $name = $city->name;
    }
  }

  /**
   * @test
   * @covers ::counties
   *
   * @return void
   */
  public function it_returns_empty_counties() {
    $state = factory(State::class)->create();
    $this->assertCount(0, $state->counties);
  }

  /**
   * @test
   * @covers ::counties
   *
   * @return void
   */
  public function it_returns_valid_counties() {
    factory(County::class, 3)->create();
    $state = factory(State::class)->create();
    factory(County::class, 2)->create(['state_id' => $state->id]);
    $counties = $state->counties;
    $this->assertCount(2, $counties);
    $name = '';
    foreach($counties as $county) {
      $this->assertEquals($county->state_id, $state->id);
      $this->assertLessThanOrEqual($county->name, $name);
      $name = $county->name;
    }
  }

  /**
   * @test
   * @covers ::findBySlug
   *
   * @return void
   */
  public function it_returns_via_slug() {
    $state = factory(State::class)->create();
    $found = State::findBySlug($state->slug);
    $this->assertEquals($state->id, $found->id);
  }

  /**
   * @test
   * @covers ::description
   *
   * @return void
   */
  public function it_returns_empty_description() {
    $state = factory(State::class)->create();
    $this->assertEmpty($state->description());
  }

  /**
   * @test
   * @covers ::description
   *
   * @return void
   */
  public function it_returns_empty_description_when_none_active() {
    $state = factory(Description::class, 'state')->create()->model;
    $this->assertEmpty($state->description());
  }

  /**
   * @test
   * @covers ::description
   *
   * @return void
   */
  public function it_returns_description_when_one_active() {
    $description = factory(Description::class, 'state')->states('active')->create();
    $state = $description->model;
    $this->assertEquals($description->id, $state->description()->id);
  }

  /**
   * @test
   * @covers ::descriptions
   *
   * @return void
   */
  public function it_returns_empty_descriptions() {
    $state = factory(State::class)->create();
    $this->assertEmpty($state->description());
  }

  /**
   * @test
   * @covers ::descriptions
   *
   * @return void
   */
  public function it_returns_multiple_descriptions() {
    $state = factory(State::class)->create();
    $description = factory(Description::class, 'state', 4)->create(['model_id' => $state->id]);
    $this->assertCount(4, $state->descriptions);
  }

}
