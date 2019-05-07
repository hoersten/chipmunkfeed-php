<?php

namespace App\Models;

use App\Traits\HasDescription;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Str;

class County extends Model {
  use HasDescription;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'state_id', 'name', 'county_type', 'county_id', 'fips', 'wikipedia', 'twitter', 'url', 'population', 'area', 'latitude', 'longitude'
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
          return Str::Slug($this->state->name) . '/' . Str::slug($this->name . ' ' . $this->county_type);
        }
      ]
    ];
  }

  public function state() {
    return $this->belongsTo(State::class);
  }

  public function capitals() {
    return $this->belongsToMany(City::class)->wherePivot('capital', '>=', 1)->orderBy('capital', 'asc');
  }

  public function cities() {
    return $this->belongsToMany(City::class)->orderBy('name');
  }
}
