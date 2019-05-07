<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\County;
use App\Models\Description;
use App\Models\State;
use Illuminate\Http\Request;

class CountyController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(State $state) {
    $breadcrumbs = [ [ 'url' => route('home'), 'text' => 'Home' ], 
                     [ 'url' => route('states.show', ['state' => $state] ), 'text' => $state->name, ], 
                     [ 'url' => route('counties.index', ['state' => $state] ), 'text' => 'Counties', 'active' => true ], 
                   ];
    $counties = $state->counties;
    return view('counties.index', [ 'counties' => $counties, 'state' => $state, 'breadcrumbs' => $breadcrumbs ] );
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\County  $county
   * @return \Illuminate\Http\Response
   */
  public function show($county) {
    $county = County::findBySlug($county);
    $state = $county->state;
    $breadcrumbs = [ [ 'url' => route('home'), 'text' => 'Home' ], 
                     [ 'url' => route('states.show', ['state' => $state] ), 'text' => $state->name, ], 
                     [ 'url' => route('counties.show', ['state' => $state->name, 'county' => $county->name ] ), 'text' => $county->name, 'active' => true ], 
                   ];
    return view('counties.show', [ 'county' => $county, 'state' => $state, 'breadcrumbs' => $breadcrumbs ] );
  }
}
