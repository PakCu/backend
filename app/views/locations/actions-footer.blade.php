<div class="well">
    @if(isset($has_submit))
        <button class="btn btn-primary">Submit</button>
    @endif
    @if(stristr(Route::currentRouteAction(), 'LocationsController@index') === 'LocationsController@index')
        <a href="{{action('LocationsController@create')}}" class="btn btn-default">Create</a>
    @else
        <a href="{{action('LocationsController@index')}}" class="btn btn-default">Back To List</a>
    @endif
    @if(isset($location) && stristr(Route::currentRouteAction(), 'LocationsController@show') === 'LocationsController@show')
        <a href="{{action('LocationsController@edit', $location->id)}}" class="btn btn-default">Edit</a>
        {{Former::open(action('LocationsController@destroy', $location->id))->class('form-inline')}}
            {{Former::hidden('_method', 'DELETE')}}
            <button type="button" class="btn btn-danger confirm-delete">Delete</button>
        {{Former::close()}}
    @endif
</div>