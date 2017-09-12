<?php

namespace App\Models;

use App\Traits\HasDescription;

class State extends Model {
  use HasDescription;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'abbreviation','country', 'state_id', 'fips', 'wikipedia', 'twitter', 'url', 'population', 'area', 'latitude', 'longitude', 'zoom'
  ];

  public function capital() {
    return $this->cities()->where('state_capital', true)->firstOrFail();
  }

  public function cities() {
    return $this->hasMany(City::class)->orderBy('name');
  }

  public function counties() {
    return $this->hasMany(County::class)->orderBy('name');
  }
}
