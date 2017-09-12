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
            %a{ 'href' => '/' . $capital->slug} #{ $capital->name }
          @endforeach
        @else
        %a{ 'href' => '/' . $county->capitals()->first()->slug} #{ $county->capitals()->first()->name }
        @endif
      @endif
      @include('shared.population', [ 'obj' => $state])
      @include('shared.area', [ 'obj' => $state])
      %li
        %strong Cities:
        %a{ 'href' => '/' . $county->slug . '/cities' } #{ number_format($county->cities->count()) . " Cities" }
    @include('shared.web_links', [ 'obj' => $state])
  .col-md-4.col-sm-6.hidden-xs
    #map_div{ 'data-state' => $state->abbreviation, 'data-center-lat' => $state->latitude, 'data-center-long' => $state->longitude, 'data-center-zoom' => $state->zoom }
@include('shared.description', [ 'obj' => $county])
@endsection