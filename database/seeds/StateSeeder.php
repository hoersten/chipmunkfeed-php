<?php

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder {
  protected const ID_INDEX = 0;
  protected const SLUG_INDEX = 1;
  protected const NAME_INDEX = 2;
  protected const ABBREVIATION_INDEX = 3;
  protected const COUNTRY_INDEX = 4;
  protected const STATE_ID_INDEX = 5;
  protected const FIPS_INDEX = 6;
  protected const LATITUDE_INDEX = 7;
  protected const LONGITUDE_INDEX = 8;
  protected const ZOOM_INDEX = 9;
  protected const WIKIPEDIA_INDEX = 10;
  protected const TWITTER_INDEX = 11;
  protected const URL_INDEX = 12;
  protected const POPULATION_INDEX = 13;
  protected const AREA_INDEX = 14;

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
    \DB::table('states')->truncate();
    \Schema::enableForeignKeyConstraints();
  }

  private function add() {
    $file = __DIR__ . '/files/states.txt';
    foreach(file($file) as $line) {
      $data = explode("\t", $line);
      // Skip header row
      if ($data[self::ID_INDEX] == "id") {
        continue;
      }
      $state = State::create([
        'id' => $data[self::ID_INDEX],
        'slug' => $data[self::SLUG_INDEX],
        'name' => $data[self::NAME_INDEX],
        'abbreviation' => $data[self::ABBREVIATION_INDEX],
        'country' => $data[self::COUNTRY_INDEX],
        'state_id' => $data[self::STATE_ID_INDEX],
        'fips' => $data[self::FIPS_INDEX],
        'latitude' => $data[self::LATITUDE_INDEX],
        'longitude' => $data[self::LONGITUDE_INDEX],
        'zoom' => $data[self::ZOOM_INDEX],
        'wikipedia' => ($data[self::WIKIPEDIA_INDEX] === '') ? null : $data[self::WIKIPEDIA_INDEX],
        'twitter' => ($data[self::TWITTER_INDEX] === '') ? null : $data[self::TWITTER_INDEX],
        'url' => ($data[self::URL_INDEX] === '') ? null : $data[self::URL_INDEX],
        'population' => ($data[self::POPULATION_INDEX] === '') ? null : $data[self::POPULATION_INDEX],
        'area' => ($data[self::AREA_INDEX] === '') ? null : $data[self::AREA_INDEX],
      ]);
    }
  }
}
