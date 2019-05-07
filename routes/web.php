<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'StaticController@home')->name('home');
Route::get('/search', 'StaticController@search')->name('search');
// States
Route::get('/states', 'StateController@index')->name('states.index');
Route::get('/{state}', 'StateController@show')->name('states.show');
// Counties
Route::get('/{state}/counties', 'CountyController@index')->name('counties.index');
Route::get('/{county}', 'CountyController@show')
  ->where('county', '((?!(massachusetts/.+-parish)|(north-carolina/the-borough)).)+-(county|borough|census-area|parish)')
	->name('counties.show');
// Cities
Route::get('/{state}/cities', 'CityController@index')->name('cities.state_index');
Route::get('/{state}/{city}', 'CityController@show')->name('cities.show');
Route::get('/{county}/cities', 'CityController@countyIndex')
  ->where('county', '.+-(county|borough|census-area|parish)')
  ->name('cities.county_index');
