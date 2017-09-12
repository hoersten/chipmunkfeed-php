<?php

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder {
  protected const ID_INDEX = 0;
  protected const STATE_ID_INDEX = 1;
  protected const SLUG_INDEX = 2;
  protected const NAME_INDEX = 3;
  protected const STATE_CAPITAL_INDEX = 4;
  protected const COUNTY_ID_INDEX = 5;
  protected const COUNTY_CAPITAL_INDEX = 6;
  protected const GNIS_INDEX = 7;
  protected const FIPS_INDEX = 8;
  protected const MSA_INDEX = 9;
  protected const USA_INDEX = 10;
  protected const CBSA_INDEX = 11;
  protected const CSA_INDEX = 12;
  protected const PSA_INDEX = 13;
  protected const DMA_INDEX = 14;
  protected const LATITUDE_INDEX = 15;
  protected const LONGITUDE_INDEX = 16;
  protected const WIKIPEDIA_INDEX = 17;
  protected const TWITTER_INDEX = 18;
  protected const URL_INDEX = 19;
  protected const POPULATION_INDEX = 20;
  protected const AREA_INDEX = 21;

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    $this->truncate();
    $this->addCities();
  }

  private function truncate() {
    \Schema::disableForeignKeyConstraints();
    \DB::table('cities')->truncate();
    \Schema::enableForeignKeyConstraints();
  }

  private function addCities() {
    $file = __DIR__ . '/files/cities.txt2';
    foreach(file($file) as $line) {
      $data = explode("\t", $line);
      // Skip header row
      if ($data[self::ID_INDEX] == "id") {
        continue;
      }
      $city = City::create([
        'id' => $data[self::ID_INDEX],
        'state_id' => $data[self::STATE_ID_INDEX],
        'slug' => $data[self::SLUG_INDEX],
        'name' => $data[self::NAME_INDEX],
        'state_capital' => ($data[self::STATE_CAPITAL_INDEX] == 1),
        'gnis' => $data[self::GNIS_INDEX],
        'fips' => $data[self::FIPS_INDEX],
        'msa' => ($data[self::MSA_INDEX] === '') ? null : $data[self::MSA_INDEX],
        'usa' => ($data[self::USA_INDEX] === '') ? null : $data[self::USA_INDEX],
        'cbsa' => ($data[self::CBSA_INDEX] === '') ? null : $data[self::CBSA_INDEX],
        'csa' => ($data[self::CSA_INDEX] === '') ? null : $data[self::CSA_INDEX],
        'psa' => ($data[self::PSA_INDEX] === '') ? null : $data[self::PSA_INDEX],
        'dma' => ($data[self::DMA_INDEX] === '') ? null : $data[self::DMA_INDEX],
        'latitude' => $data[self::LATITUDE_INDEX],
        'longitude' => $data[self::LONGITUDE_INDEX],
        'wikipedia' => ($data[self::WIKIPEDIA_INDEX] === '') ? null : $data[self::WIKIPEDIA_INDEX],
        'twitter' => ($data[self::TWITTER_INDEX] === '') ? null : $data[self::TWITTER_INDEX],
        'url' => ($data[self::URL_INDEX] === '') ? null : $data[self::URL_INDEX],
        'population' => ($data[self::POPULATION_INDEX] === '') ? null : $data[self::POPULATION_INDEX],
        'area' => ($data[self::AREA_INDEX] === '') ? null : $data[self::AREA_INDEX],
      ]);
      $city->counties()->attach($data[self::COUNTY_ID_INDEX], ['capital' => (int)$data[self::COUNTY_CAPITAL_INDEX]]);
      $city->save();
    }
 }
}