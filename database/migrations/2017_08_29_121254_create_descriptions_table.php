<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescriptionsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('descriptions', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('model_id');
      $table->string('model_type');
      $table->text('description');
      $table->boolean('active')->default(false);
      $table->string('tag');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('descriptions');
  }
}
