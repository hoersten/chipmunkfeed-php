<?php

namespace App\Models;

use App\Traits\HasDescription;
use Cviebrock\EloquentSluggable\Sluggable;

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
        'unique' => false
      ]
    ];
  }

  public function state() {
    return $this->belongsTo(State::class);
  }

  public function capitals() {
    return $this->cities()->wherePivot('capital', '>=', 1)->orderBy('capital');
  }

  public function cities() {
    return $this->belongsToMany(City::class)->orderBy('name');
  }

  protected function getSlugNameAttribute() {
    return $this->state->name . '/' . $this->name;
  }
}
