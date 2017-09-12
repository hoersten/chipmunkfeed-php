<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run() {
    $this->call(StateSeeder::class);
    $this->call(CountySeeder::class);
    $this->call(CitySeeder::class);
  }
}
