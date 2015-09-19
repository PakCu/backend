<div class="well">
    @if(isset($has_submit))
        <button class="btn btn-primary">Submit</button>
    @endif
    @if(stristr(Route::currentRouteAction(), 'TalksController@index') === 'TalksController@index')
        <a href="{{action('TalksController@create')}}" class="btn btn-default">Create</a>
    @else
        <a href="{{action('TalksController@index')}}" class="btn btn-default">Back To List</a>
    @endif
    @if(isset($talk) && stristr(Route::currentRouteAction(), 'TalksController@show') === 'TalksController@show')
        <a href="{{action('TalksController@edit', $talk->id)}}" class="btn btn-default">Edit</a>
        {{Former::open(action('TalksController@destroy', $talk->id))->class('form-inline')}}
            {{Former::hidden('_method', 'DELETE')}}
            <button type="button" class="btn btn-danger confirm-delete">Delete</button>
        {{Former::close()}}
    @endif
</div>