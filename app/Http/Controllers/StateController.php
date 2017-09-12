<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    $breadcrumbs = [ [ 'url' => route('home'), 'text' => 'Home' ], 
                     [ 'url' => route('states.index'), 'text' => 'States', 'active' => true ], ];
    $states = State::orderBy('name')->get();
    return view('states.index', [ 'states' => $states, 'breadcrumbs' => $breadcrumbs ] );
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\State  $state
   * @return \Illuminate\Http\Response
   */
  public function show(State $state) {
    $breadcrumbs = [ [ 'url' => route('home'), 'text' => 'Home' ], 
                     [ 'url' => route('states.show', ['state' => $state]), 'text' => $state->name, 'active' => true ], ];
    return view('states.show', [ 'state' => $state, 'breadcrumbs' => $breadcrumbs ] );
  }
}
