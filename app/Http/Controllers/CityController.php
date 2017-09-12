<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\County;
use App\Models\Description;
use App\Models\State;

use Illuminate\Http\Request;

class CityController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @param \App\Model\State $state
   * @return \Illuminate\Http\Response
   */
  public function index(State $state) {
    $breadcrumbs = [ [ 'url' => route('home'), 'text' => 'Home' ], 
                     [ 'url' => route('states.show', ['state' => $state] ), 'text' => $state->name, ], 
                     [ 'url' => route('cities.state_index', ['state' => $state] ), 'text' => 'Cities', 'active' => true ], 
                   ];
    $cities = $state->cities;
    return view('cities.index', ['cities' => $cities, 'state' => $state, 'breadcrumbs' => $breadcrumbs]);
  }

  /**
   * Display a listing of the resource.
   *
   * @param \App\Model\County $county
   * @return \Illuminate\Http\Response
   */
  public function countyIndex($state, $county) {
    $county = County::find_by_slug($state . '/' . $county);
    $state = $county->state;
    $breadcrumbs = [ [ 'url' => route('home'), 'text' => 'Home' ], 
                     [ 'url' => route('states.show', ['state' => $state] ), 'text' => $state->name, ], 
                     [ 'url' => route('counties.show', ['state' => $state, 'county' => $county] ), 'text' => $county->name, ], 
                     [ 'url' => route('cities.county_index', ['state' => $state, 'county' => $county] ), 'text' => 'Cities', 'active' => true ], 
                   ];
    $cities = $county->cities;
    return view('cities.index', ['cities' => $cities, 'county' => $county, 'state' => $state, 'breadcrumbs' => $breadcrumbs]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  string  $state
   * @param  string  $city
   * @return \Illuminate\Http\Response
   */
  public function show($state, $city) {
    $city = City::find_by_slug($state . '/' . $city);
    $state = $city->state;
    $breadcrumbs = [ [ 'url' => route('home'), 'text' => 'Home' ], 
                     [ 'url' => route('states.show', ['state' => $state] ), 'text' => $state->name, ], 
                     [ 'url' => route('cities.show', ['state' => $state->name, 'city' => $city->name ] ), 'text' => $city->name, 'active' => true ], 
                   ];
    return view('cities.show', ['city' => $city, 'breadcrumbs' => $breadcrumbs]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\City  $city
   * @return \Illuminate\Http\Response
   */
  public function edit(City $city) {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\City  $city
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, City $city) {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\City  $city
   * @return \Illuminate\Http\Response
   */
  public function destroy(City $city) {
    //
  }
}
