@extends('layouts.default')
@section('content')
    <h2>Edit Talk</h2>
    <hr>
    {{ Former::open(action('TalksController@update', $talk->id)) }}
        {{Former::populate($talk)}}
        {{Former::hidden('_method', 'PUT')}}
        @include('talks.form')
        @include('talks.actions-footer', ['has_submit' => true])
@stop