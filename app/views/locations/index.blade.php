@extends('layouts.default')
@section('content')
    <h2>Locations</h2>
    <hr>
    <table data-path="{{action('LocationsController@index')}}" class="DT table table-striped table-hover table-bordered">
        <thead>
            <tr>
                
                <th>Device Hash</th>
                <th>Name</th>

                <th width="200px">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <br>
    @include('locations.actions-footer', ['is_list' => true])
@stop