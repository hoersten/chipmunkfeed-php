<?php

namespace Tests\Unit\Models;

use App\Models\City;
use App\Models\County;
use App\Models\Description;
use App\Models\State;
use App\Models\Template;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @coversDefaultClass App\Models\Template
 */
class TemplateModelTest extends TestCase {
  use DatabaseMigrations;
  /**
   * @test
   * @covers ::scopeActive
   *
   * @return void
   */
  public function it_returns_active_templates() {
    $state = factory(Template::class, 'state')->states('active')->create()->model;
    $city = factory(Template::class, 'city')->states('active')->create()->model;
    $county = factory(Template::class, 'county')->states('active')->create()->model;
    $templates = Template::active()->get();
    $this->assertCount(3, $templates);
  }
  /**
   * @test
   * @covers ::scopeActive
   *
   * @return void
   */
  public function it_returns_active_description_when_inactive_exist() {
    $state = factory(Template::class, 'state')->states('active')->create()->model;
    $city = factory(Template::class, 'city')->states('active')->create()->model;
    $county = factory(Template::class, 'county')->states('active')->create()->model;
    $state = factory(Template::class, 'state')->create()->model;
    $city = factory(Template::class, 'city')->create()->model;
    $county = factory(Template::class, 'county')->create()->model;
    $templates = Template::active()->get();
    $this->assertCount(3, $templates);
  }

}
