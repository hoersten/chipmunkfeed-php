<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel {
  use Sluggable;

  /**
   * Return the sluggable configuration array for this model.
   *
   * @return array
   */
  public function sluggable() {
    return [
      'slug' => [
        'source' => 'name'
      ]
    ];
  }

  /**
   * Get the route key for the model.
   *
   * @return string
   */
  public function getRouteKeyName() {
    return 'slug';
  }

  static public function findBySlug($slug) {
    return self::where(['slug' => $slug])->firstOrFail();
  }
}
