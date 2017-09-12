<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountiesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('counties', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('state_id')->references('id')->on('states')->onUpdate('cascade')->onDelete('restrict');
      $table->string('slug');
      $table->string('name');
      $table->string('county_type')->default('County');
      $table->integer('county_id')->nullable();
      $table->string('fips', 5)->nullable();
      $table->string('wikipedia')->nullable();
      $table->string('twitter')->nullable();
      $table->string('url')->nullable();
      $table->integer('population')->nullable();
      $table->float('area')->nullable();
      $table->decimal('latitude', 10, 7)->nullable();
      $table->decimal('longitude', 10, 7)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('counties');
  }
}
