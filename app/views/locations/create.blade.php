@extends('layouts.default')
@section('content')
    <h2>New Location</h2>
    <hr>
    {{ Former::open(action('LocationsController@store')) }}
    @include('locations.form')
    @include('locations.actions-footer', ['has_submit' => true])
@stop