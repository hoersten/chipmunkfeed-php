<?php

namespace App\Traits;

use App\Models\Description;

trait HasDescription {
  public function description() {
    return $this->descriptions()->active()->first();
  }
  public function descriptions() {
    return $this->morphMany(Description::class, 'model');
  }
}