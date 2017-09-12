<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Description extends Model {
  public function scopeActive($query) {
    return $query->where('active', '=', true);
  }

  public function model() {
    return $this->morphTo();
  }
}
