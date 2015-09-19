@extends('layouts.default')
@section('content')
    <h2>View Location</h2>
    <hr>
    {{ Former::open() }}
        {{Former::populate($location)}}
        @include('locations.form')
        @include('locations.actions-footer')
@stop