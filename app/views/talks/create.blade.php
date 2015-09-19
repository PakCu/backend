@extends('layouts.default')
@section('content')
    <h2>New Talk</h2>
    <hr>
    {{ Former::open(action('TalksController@store')) }}
    @include('talks.form')
    @include('talks.actions-footer', ['has_submit' => true])
@stop