<?php

class LocationsController extends \BaseController {

	/**
	 * Display a listing of locations
	 *
	 * @return Response
	 */
	public function index()
	{
		if(!Location::canList())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			$locations = Location::select([
				'locations.id',
                'locations.device_hash',
                'locations.name',
'locations.id as actions'
            ]);
			return Datatables::of($locations)
                ->edit_column('actions', function($location){
                    $actions   = [];
                    $actions[] = $location->canShow() ? link_to_action('LocationsController@show', 'Show', $location->id, ['class' => 'btn btn-xs btn-primary'] ) : '';
                    $actions[] = $location->canUpdate() ? link_to_action('LocationsController@edit', 'Update', $location->id, ['class' => 'btn btn-xs btn-default'] ) : '';
                    $actions[] = $location->canDelete() ? Former::open(action('LocationsController@destroy', $location->id))->class('form-inline') 
                    . Former::hidden('_method', 'DELETE')
                    . '<button type="button" class="btn btn-xs btn-danger confirm-delete">Delete</button>'
                    . Former::close() : '';
                    return implode(' ', $actions);
                })
                ->remove_column('id')
                ->make();
        }
        Asset::push('js', 'datatables');
        return View::make('locations.index');
    }

	/**
	 * Show the form for creating a new location
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!Location::canCreate())
		{
			return $this->_access_denied();
		}
		return View::make('locations.create');
	}

	/**
	 * Store a newly created location in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
		Location::setRules('store');
		if(!Location::canCreate())
		{
			return $this->_access_denied();
		}
		$location = new Location;
		$location->fill($data);
		if(!$location->save())
		{
			return $this->_validation_error($location);
		}
		if(Request::ajax())
		{
			return Response::json($location, 201);
		}
		return Redirect::action('LocationsController@index')
         ->with('notification:success', $this->created_message);
     }

	/**
	 * Display the specified location.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$location = Location::findOrFail($id);
		if(!$location->canShow())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			return Response::json($location);
		}
		Asset::push('js', 'show');
		return View::make('locations.show', compact('location'));
	}

	/**
	 * Show the form for editing the specified location.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$location = Location::findOrFail($id);
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!$location->canUpdate())
		{
			return $this->_access_denied();
		}
		return View::make('locations.edit', compact('location'));
	}

	/**
	 * Update the specified location in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$location = Location::findOrFail($id);
		Location::setRules('update');
		$data = Input::all();
		if(!$location->canUpdate())
		{
			return $this->_access_denied();
		}
		if(!$location->update($data)) {
			return $this->_validation_error($location);
		}
		if(Request::ajax())
		{
			return $location;
		}
		Session::remove('_old_input');
		return Redirect::action('LocationsController@edit', $id)
            ->with('notification:success', $this->updated_message);
    }

	/**
	 * Remove the specified location from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$location = Location::findOrFail($id);
		if(!$location->canDelete())
		{
			return $this->_access_denied();
		}
		$location->delete();
		if(Request::ajax())
		{
			return Response::json($this->deleted_message);
		}
		return Redirect::action('LocationsController@index')
            ->with('notification:success', $this->deleted_message);
    }

	/**
	 * Custom Methods. Dont forget to add these to routes: Route::get('example/name', 'ExampleController@getName');
	 */
	
	// public function getName()
	// {
	// }

	/**
	 * Constructor
	 */

	public function __construct()
	{
		parent::__construct();
		View::share('controller', 'Location');
	}

}
