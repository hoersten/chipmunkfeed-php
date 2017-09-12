@extends('layouts.app')

@section('title')
States
@endsection

@section('content')
@include('shared.breadcrumbs', [ 'breadcrumbs' => $breadcrumbs])
.row
  .col-md-8.col-sm-6
    %h1
      States
    %h2 Description:
.row
  .col-12
    %h3
      List of States
    %ul.list-unstyled.row
      @foreach($states as $state)
      %li.col-md-3.col-sm-4.col-6
        %a{ 'href' => route('states.show', $state) } #{ $state->name }
      @endforeach
@endsection