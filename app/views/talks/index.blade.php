@extends('layouts.default')
@section('content')
    <h2>Talks</h2>
    <hr>
    <table data-path="{{action('TalksController@index')}}" class="DT table table-striped table-hover table-bordered">
        <thead>
            <tr>
                
                <th>User</th>
                <th>Location</th>
                <th>Title</th>
                <th>Youtube Url</th>
                <th>Rmtp Url</th>
                <th>Status</th>

                <th width="200px">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <br>
    @include('talks.actions-footer', ['is_list' => true])
@stop