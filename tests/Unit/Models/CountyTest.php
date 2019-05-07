<?php

namespace Tests\Unit\Models;

use App\Models\City;
use App\Models\County;
use App\Models\Description;
use App\Models\State;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @coversDefaultClass App\Models\County
 */
class CountyModelTest extends TestCase {
  use DatabaseMigrations;
  /**
   * @test
   * @covers ::capitals
   *
   * @return void
   */
  public function it_returns_empty_capitals() {
    $county = factory(County::class)->create();
    $cities = factory(City::class, 3)->create();
    foreach($cities as $city) {
      $county->cities()->attach($city);
    }
    $this->assertCount(0, $county->capitals);
  }

  /**
   * @test
   * @covers ::capitals
   *
   * @return void
   */
  public function it_returns_existing_capital() {
    $county = factory(County::class)->create();
    $cities = factory(City::class, 3)->create();
    foreach($cities as $city) {
      $county->cities()->attach($city);
    }
    $city = factory(City::class)->create();
    $county->cities()->attach($city, ['capital' => 1]);
    $this->assertEquals($city->id, $county->capitals()->first()->id);
  }

  /**
   * @test
   * @covers ::capitals
   *
   * @return void
   */
  public function it_returns_multiple_capitals() {
    $county = factory(County::class)->create();
    $cities = factory(City::class, 3)->create();
    foreach($cities as $city) {
      $county->cities()->attach($city);
    }
    $city = factory(City::class)->create();
    $county->cities()->attach($city, ['capital' => 2]);
    $city2 = factory(City::class)->create();
    $county->cities()->attach($city2, ['capital' => 1]);
    $capitals = $county->capitals()->get();
    $this->assertCount(2, $capitals);
    $this->assertEquals($city2->id, $capitals[0]->id);
    $this->assertEquals($city->id, $capitals[1]->id);
  }

  /**
   * @test
   * @covers ::cities
   *
   * @return void
   */
  public function it_returns_empty_cities() {
    $county = factory(County::class)->create();
    $this->assertCount(0, $county->cities);
  }

  /**
   * @test
   * @covers ::cities
   *
   * @return void
   */
  public function it_returns_valid_cities() {
    factory(City::class, 3)->create();
    $county = factory(County::class)->create();
    $cities = factory(City::class, 2)->create();
    foreach ($cities as $city) {
      $county->cities()->attach($city);
    }
    $cities = $county->cities;
    $this->assertCount(2, $cities);
    $name = '';
    foreach($cities as $city) {
      $this->assertEquals($city->counties()->first()->id, $county->id);
      $this->assertLessThanOrEqual($city->name, $name);
      $name = $city->name;
    }
  }

  /**
   * @test
   * @covers ::state
   *
   * @return void
   */
  public function it_returns_state() {
    $state = factory(State::class)->create();
    $county = factory(County::class)->create(['state_id' => $state->id]);
    $this->assertEquals($state->id, $county->state->id);
  }

  /**
   * @test
   * @covers ::findBySlug
   *
   * @return void
   */
  public function it_returns_via_slug() {
    $county = factory(County::class)->create();
    $found = County::findBySlug($county->slug);
    $this->assertEquals($county->id, $found->id);
  }

  /**
   * @test
   * @covers ::description
   *
   * @return void
   */
  public function it_returns_empty_description() {
    $county = factory(County::class)->create();
    $this->assertEmpty($county->description());
  }

  /**
   * @test
   * @covers ::description
   *
   * @return void
   */
  public function it_returns_empty_description_when_none_active() {
    $county = factory(Description::class, 'county')->create()->model;
    $this->assertEmpty($county->description());
  }

  /**
   * @test
   * @covers ::description
   *
   * @return void
   */
  public function it_returns_description_when_one_active() {
    $description = factory(Description::class, 'county')->states('active')->create();
    $county = $description->model;
    $this->assertEquals($description->id, $county->description()->id);
  }

  /**
   * @test
   * @covers ::descriptions
   *
   * @return void
   */
  public function it_returns_empty_descriptions() {
    $county = factory(County::class)->create();
    $this->assertEmpty($county->description());
  }

  /**
   * @test
   * @covers ::descriptions
   *
   * @return void
   */
  public function it_returns_multiple_descriptions() {
    $county = factory(County::class)->create();
    $description = factory(Description::class, 'county', 4)->create(['model_id' => $county->id]);
    $this->assertCount(4, $county->descriptions);
  }

}
