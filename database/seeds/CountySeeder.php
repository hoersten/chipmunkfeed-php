<?php

use App\Models\County;
use Illuminate\Database\Seeder;

class CountySeeder extends Seeder {
  protected const ID_INDEX = 0;
  protected const STATE_ID_INDEX = 1;
  protected const SLUG_INDEX = 2;
  protected const NAME_INDEX = 3;
  protected const COUNTY_TYPE_INDEX = 4;
  protected const COUNTY_ID_INDEX = 5;
  protected const FIPS_INDEX = 6;
  protected const WIKIPEDIA_INDEX = 7;
  protected const TWITTER_INDEX = 8;
  protected const URL_INDEX = 9;
  protected const POPULATION_INDEX = 10;
  protected const AREA_INDEX = 11;

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    $this->truncate();
    $this->add();
  }

  private function truncate() {
    \Schema::disableForeignKeyConstraints();
    \DB::table('counties')->truncate();
    \Schema::enableForeignKeyConstraints();
  }

  private function add() {
    $file = __DIR__ . '/files/counties.txt';
    foreach(file($file) as $line) {
      $data = explode("\t", $line);
      // Skip header row
      if ($data[self::ID_INDEX] == "id") {
        continue;
      }
      $state = County::create([
        'id' => $data[self::ID_INDEX],
        'state_id' => $data[self::STATE_ID_INDEX],
        'slug' => $data[self::SLUG_INDEX],
        'name' => $data[self::NAME_INDEX],
        'county_type' => $data[self::COUNTY_TYPE_INDEX],
        'county_id' => $data[self::COUNTY_ID_INDEX],
        'fips' => $data[self::FIPS_INDEX],
        'wikipedia' => ($data[self::WIKIPEDIA_INDEX] === '') ? null : $data[self::WIKIPEDIA_INDEX],
        'twitter' => ($data[self::TWITTER_INDEX] === '') ? null : $data[self::TWITTER_INDEX],
        'url' => ($data[self::URL_INDEX] === '') ? null : $data[self::URL_INDEX],
        'population' => ($data[self::POPULATION_INDEX] === '') ? null : $data[self::POPULATION_INDEX],
        'area' => ($data[self::AREA_INDEX] === '') ? null : $data[self::AREA_INDEX],
      ]);
    }
  }
}
