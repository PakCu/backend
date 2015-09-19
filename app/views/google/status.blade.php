@extends('layouts.default')
@section('content')
    <h2>Google Auth</h2>
    <hr>
    <h3>Status: Online</h3>
    <a href="{{action('GoogleAuthController@getRevoke')}}">Revoke</a>
@stop