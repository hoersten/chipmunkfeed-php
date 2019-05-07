@extends('layouts.app')

@section('title')
#{'Cities in ' . (isset($county) ? $county->name . ', ' : "") . $state->name }
@endsection

@section('content')
@include('shared.breadcrumbs', [ 'breadcrumbs' => $breadcrumbs])
.row
  .col-md-8.col-sm-6
    %h1 
      #{'Cities in ' . (isset($county) ? $county->name . ', ' : "") . $state->name }
    @include('shared.description', [ 'obj' => (isset($county) ? $county : $state)])
  .col-md-4.col-sm-6.hidden-xs
    #map_div{ 'data-state' => $state->abbreviation, 'data-center-lat' => $state->latitude, 'data-center-long' => $state->longitude, 'data-center-zoom' => $state->zoom }
.row
  .col-md-12
    %h3 
      List of Cities
    %ul.list-unstyled.row
      @foreach($cities as $city)
      %li.col-md-3.col-sm-4.col-6
        %a{ 'href' => route('cities.show', [ 'state' => '', 'city' => $city ]) } #{ $city->name }
        //=city.decorate.display_capital_info
      @endforeach
@endsection