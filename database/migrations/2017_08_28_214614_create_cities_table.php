<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('cities', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('state_id')->references('id')->on('states')->onUpdate('cascade')->onDelete('restrict');
      $table->string('slug');
      $table->string('name');
      $table->boolean('state_capital')->default(false);
      $table->string('gnis');
      $table->string('fips', 5)->nullable();
      $table->integer('msa')->nullable();
      $table->integer('usa')->nullable();
      $table->integer('cbsa')->nullable();
      $table->integer('csa')->nullable();
      $table->integer('psa')->nullable();
      $table->integer('dma')->nullable();
      $table->string('wikipedia')->nullable();
      $table->string('twitter')->nullable();
      $table->string('url')->nullable();
      $table->integer('elevation')->nullable();
      $table->integer('population')->nullable();
      $table->float('area')->nullable();
      $table->decimal('latitude', 10, 7)->nullable();
      $table->decimal('longitude', 10, 7)->nullable();
      $table->timestamps();
    });

    Schema::create('city_county', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('county_id')->references('id')->on('counties')->onUpdate('cascade')->onDelete('restrict');
      $table->integer('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('restrict');
      $table->tinyInteger('capital')->default(0);
      $table->timestamps();
    });
  }
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('city_county');
    Schema::dropIfExists('cities');
  }
}
