<?php

namespace Tests\Unit\Models;

use App\Models\City;
use App\Models\County;
use App\Models\Description;
use App\Models\State;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @coversDefaultClass App\Models\City
 */
class CityModelTest extends TestCase {
  use DatabaseMigrations;
  /**
   * @test
   * @covers ::counties
   *
   * @return void
   */
  public function it_returns_one_county() {
    $county = factory(County::class)->create();
    $city = factory(City::class)->create();
    $city->counties()->attach($county);
    $this->assertCount(1, $city->counties);
  }

  /**
   * @test
   * @covers ::counties
   *
   * @return void
   */
  public function it_returns_multiple_counties() {
    $counties = factory(County::class, 2)->create();
    $city = factory(City::class)->create();
    $ids = [];
    foreach($counties as $county) {
      $city->counties()->attach($county);
      $ids[] = $county->id;
    }
    $this->assertCount(2, $city->counties);
    foreach($counties as $county) {
      $this->assertContains($county->id, $ids);
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
    $city = factory(City::class)->create(['state_id' => $state->id]);
    $this->assertEquals($state->id, $city->state->id);
  }

  /**
   * @test
   * @covers ::findBySlug
   *
   * @return void
   */
  public function it_returns_via_slug() {
    $city = factory(City::class)->create();
    $found = City::findBySlug($city->slug);
    $this->assertEquals($city->id, $found->id);
  }

  /**
   * @test
   * @covers ::description
   *
   * @return void
   */
  public function it_returns_empty_description() {
    $city = factory(City::class)->create();
    $this->assertEmpty($city->description());
  }

  /**
   * @test
   * @covers ::description
   *
   * @return void
   */
  public function it_returns_empty_description_when_none_active() {
    $city = factory(Description::class, 'city')->create()->model;
    $this->assertEmpty($city->description());
  }

  /**
   * @test
   * @covers ::description
   *
   * @return void
   */
  public function it_returns_description_when_one_active() {
    $description = factory(Description::class, 'city')->states('active')->create();
    $city = $description->model;
    $this->assertEquals($description->id, $city->description()->id);
  }

  /**
   * @test
   * @covers ::descriptions
   *
   * @return void
   */
  public function it_returns_empty_descriptions() {
    $city = factory(City::class)->create();
    $this->assertEmpty($city->description());
  }

  /**
   * @test
   * @covers ::descriptions
   *
   * @return void
   */
  public function it_returns_multiple_descriptions() {
    $city = factory(City::class)->create();
    $description = factory(Description::class, 'city', 4)->create(['model_id' => $city->id]);
    $this->assertCount(4, $city->descriptions);
  }

  /**
   * @test
   * @covers ::addDescription
   *
   * @return void
   */
  public function it_adds_a_description() {
    $city = factory(City::class)->create();
    $desc = 'Test description';
    $tag = 'Tag A';
    $city->addDescription($desc, $tag);
    $this->assertEquals($desc, $city->description()->description);
    $this->assertEquals($tag, $city->description()->tag);
    $this->assertCount(1, $city->descriptions()->active()->get());
  }

  /**
   * @test
   * @covers ::addDescription
   *
   * @return void
   */
  public function it_adds_an_inactive_description() {
    $city = factory(City::class)->create();
    $description = factory(Description::class, 'city')->state('active')->create(['model_id' => $city->id]);
    $descOld = $city->description()->description;
    $desc = 'Test description';
    $tag = 'Tag A';
    $city->addDescription($desc, $tag, false);
    $this->assertEquals($descOld, $city->description()->description);
    $this->assertCount(1, $city->descriptions()->active()->get());
  }
}
