<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model {
  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'model_type', 'template', 'tag', 'active',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'active' => 'boolean',
  ];

  public function scopeActive($query) {
    return $query->where('active', '=', true);
  }
}
