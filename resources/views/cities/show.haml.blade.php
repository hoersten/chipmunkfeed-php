@extends('layouts.app')

@section('title')
Learn more about #{ $city->name }
@endsection

@section('content')
@include('shared.breadcrumbs', [ 'breadcrumbs' => $breadcrumbs])
.row
  .col-md-8.col-sm-6
    %h1 
      #{ $city->name }
    %ul
      %li
        %strong State:
        %a{'href' => route('states.show', ['state' => $city->state])}<
          #{ $city->state->name }
        @if ($city->state_capital)
        (State capital)
        @endif
      @if ($city->counties()->count() > 0)
      %li
        %strong Primary #{ $city->counties()->first()->county_type}:
        %a{'href' => route('counties.show', ['county' => $city->counties()->first() ]) }<
          #{ $city->counties()->first()->name}
        @if ($city->counties()->where('capital', '>=', 1)->count() > 0)
        (#{ $city->counties()->first()->county_type} capital)
        @endif
      @if ($city->counties()->count() > 1)
      %li
        %strong #{'Other ' . str_plural($city->counties()->first()->county_type, $city->counties()->count() - 1) . ':' }
        @foreach($city->counties()->skip(1)->limit(100)->get() as $county)
        %a{'href' => route('counties.show', [ 'county' => $county ]) }<
          #{ $county->name}
        @endforeach
      @endif
      @endif
      @include('shared.population', [ 'obj' => $city])
      @include('shared.area', [ 'obj' => $city])
    @include('shared.web_links', [ 'obj' => $city])
  .col-md-4.col-sm-6.hidden-xs
    #map_div{ 'data-city-lat' => $city->latitude, 'data-city-long' => $city->longitude, 'data-state' => $city->state->abbreviation, 'data-center-lat' => $city->state->latitude, 'data-center-long' => $city->state->longitude, 'data-center-zoom' => $city->state->zoom }
@include('shared.description', [ 'obj' => $city])
@endsection