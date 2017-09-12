@extends('layouts.app')

@section('title')
#{ 'Counties in ' . $state->name }
@endsection

@section('content')
@include('shared.breadcrumbs', [ 'breadcrumbs' => $breadcrumbs])
.row
  .col-md-8.col-sm-6
    %h1
      #{ 'Counties in ' . $state->name }
    @include('shared.description', ['obj' => $state])
  .col-md-4.col-sm-6.hidden-xs
    #map_div{ 'data-state' => $state->abbreviation, 'data-center-lat' => $state->latitude, 'data-center-long' => $state->longitude, 'data-center-zoom' => $state->zoom }
.row
  .col-md-12
    %h3 
      List of Counties
    %ul.list-unstyled.row
      @foreach($counties as $county)
      %li.col-md-3.col-sm-4.col-6
        %a{ 'href' => '/' . $county->slug } #{ $county->name }
      @endforeach
@endsection