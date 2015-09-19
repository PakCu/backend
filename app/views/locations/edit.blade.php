@extends('layouts.default')
@section('content')
    <h2>Edit Location</h2>
    <hr>
    {{ Former::open(action('LocationsController@update', $location->id)) }}
        {{Former::populate($location)}}
        {{Former::hidden('_method', 'PUT')}}
        @include('locations.form')
        @include('locations.actions-footer', ['has_submit' => true])
@stop