@extends('layouts.app')

@section('title')
Learn more about #{ $county->name }
@endsection

@section('content')
@include('shared.breadcrumbs', [ 'breadcrumbs' => $breadcrumbs])
.row
  .col-md-8.col-sm-6
    %h1
      #{ $county->name }
    %ul
      %li
        %strong State:
        %a{ 'href' => route('states.show', ['state' => $state]) } #{ $state->name }
      @if ($county->capitals->count() > 0)
      %li
        %strong
          #{$county->county_type} #{str_plural('Seat', $county->capitals->count())}:
        @if ($county->capitals()->count() > 1)
        %ul.list-no-style.list-inline
          @foreach($county->capitals as $index => $capital)
          %li
            %a{ 'href' => route('cities.show', ['state' => '', 'city' => $capital ]) } #{ $capital->name }
          @endforeach
        @else
        %a{ 'href' => route('cities.show', ['state' => '', 'city' => $county->capitals()->first() ]) } #{ $county->capitals()->first()->name }
        @endif
      @endif
      @include('shared.population', [ 'obj' => $county])
      @include('shared.area', [ 'obj' => $county])
      %li
        %strong Cities:
        %a{ 'href' => route('counties.show', [ 'county' => $county ]) . '/cities' } #{ number_format($county->cities->count()) . " Cities" }
    @include('shared.web_links', [ 'obj' => $county])
  .col-md-4.col-sm-6.hidden-xs
    #map_div{ 'data-state' => $state->abbreviation, 'data-center-lat' => $state->latitude, 'data-center-long' => $state->longitude, 'data-center-zoom' => $state->zoom }
@include('shared.description', [ 'obj' => $county])
@endsection