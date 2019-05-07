<?php

namespace Tests;

use App\Models\City;
use App\Models\County;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
  use CreatesApplication;

  protected function linkCitiesAndCounty(City $city, County $county, int $capital = 0) {
    $county->cities()->attach($city, [ 'capital' => $capital ]);
  }
}
