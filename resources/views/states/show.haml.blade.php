@extends('layouts.app')

@section('title')
Learn more about #{ $state->name }
@endsection

@section('content')
@include('shared.breadcrumbs', [ 'breadcrumbs' => $breadcrumbs])
.row
  .col-md-8.col-6
    %h1 #{ $state->name }
    %ul
      @if ($state->capital() != null)
      %li
        %strong Capital:
        %a{ 'href' => route('cities.show', ['state' => '', 'city' => $state->capital()]) } #{ $state->capital()->name }
      @endif
      %li
        %strong Abbreviation:
        #{ $state->abbreviation }
      @include('shared.population', [ 'obj' => $state])
      @include('shared.area', [ 'obj' => $state])
      %li
        %strong Counties:
        %a{ 'href' => route('counties.index', $state) } #{ number_format($state->counties->count()) . " Counties" }
      %li
        %strong Cities:
        %a{ 'href' => route('cities.state_index', $state) } #{ number_format($state->cities->count()) . " Cities" }
    @include('shared.web_links', [ 'obj' => $state])
  .col-md-4.col-sm-6.hidden-xs
    #map_div{ 'data-state' => $state->abbreviation, 'data-center-lat' => $state->latitude, 'data-center-long' => $state->longitude, 'data-center-zoom' => $state->zoom }

@include('shared.description', [ 'obj' => $state])
@endsection