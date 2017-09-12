<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('states', function (Blueprint $table) {
      $table->increments('id');
      $table->string('slug')->unique();
      $table->string('name');
      $table->string('abbreviation', 3);
      $table->string('country')->default('US');
      $table->integer('state_id')->nullable();
      $table->string('fips', 5)->nullable();
      $table->string('wikipedia')->nullable();
      $table->string('twitter')->nullable();
      $table->string('url')->nullable();
      $table->integer('population')->nullable();
      $table->float('area')->nullable();
      $table->decimal('latitude', 10, 7)->nullable();
      $table->decimal('longitude', 10, 7)->nullable();
      $table->integer('zoom')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('states');
  }
}
