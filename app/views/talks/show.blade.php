@extends('layouts.default')
@section('content')
    <h2>View Talk</h2>
    <hr>
    {{ Former::open() }}
        {{Former::populate($talk)}}
        @include('talks.form')
        @include('talks.actions-footer')
@stop