<?php

namespace App\Models;

use App\Traits\HasDescription;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Str;

class City extends Model {
  use HasDescription;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'state_id', 'name', 'state_capital', 'gnis', 'fips', 'msa', 'usa', 'cbsa', 'csa', 'psa', 'dma', 'wikipedia', 'twitter', 'url', 'population', 'area', 'latitude', 'longitude'
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
      'state_capital' => 'boolean',
  ];

  /**
   * Return the sluggable configuration array for this model.
   *
   * @return array
   */
  public function sluggable() {
    return [
      'slug' => [
        'source' => 'name',
        'unique' => true,
        'method' => function($string, $separator) {
          return Str::Slug($this->state->name) . '/' . Str::slug($this->name);
        }
      ]
    ];
  }

  public function counties() {
    return $this->belongsToMany(County::class)->withTimestamps()->orderBy('name');
  }

  public function state() {
    return $this->belongsTo(State::class);
  }
}
