<?php

namespace Tests\Unit\Models;

use App\Models\City;
use App\Models\County;
use App\Models\Description;
use App\Models\State;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @coversDefaultClass App\Models\Description
 */
class DescriptionModelTest extends TestCase {
  use DatabaseMigrations;
  /**
   * @test
   * @covers ::scopeActive
   *
   * @return void
   */
  public function it_returns_active_description() {
    $state = factory(Description::class, 'state')->states('active')->create()->model;
    $city = factory(Description::class, 'city')->states('active')->create()->model;
    $county = factory(Description::class, 'county')->states('active')->create()->model;
    $descriptions = Description::active()->get();
    $this->assertCount(3, $descriptions);
  }
  /**
   * @test
   * @covers ::scopeActive
   *
   * @return void
   */
  public function it_returns_active_description_when_inactive_exist() {
    $state = factory(Description::class, 'state')->states('active')->create()->model;
    $city = factory(Description::class, 'city')->states('active')->create()->model;
    $county = factory(Description::class, 'county')->states('active')->create()->model;
    $state = factory(Description::class, 'state')->create()->model;
    $city = factory(Description::class, 'city')->create()->model;
    $county = factory(Description::class, 'county')->create()->model;
    $descriptions = Description::active()->get();
    $this->assertCount(3, $descriptions);
  }
  /**
   * @test
   * @covers ::model
   *
   * @return void
   */
  public function it_returns_proper_models() {
    $description = factory(Description::class, 'state')->create();
    $this->assertEquals(get_class($description->model), State::class);
    $description = factory(Description::class, 'city')->create();
    $this->assertEquals(get_class($description->model), City::class);
    $description = factory(Description::class, 'county')->create();
    $this->assertEquals(get_class($description->model), County::class);
  }

}
