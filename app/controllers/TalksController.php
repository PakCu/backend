<?php

class TalksController extends \BaseController {

	/**
	 * Display a listing of talks
	 *
	 * @return Response
	 */
	public function index()
	{
		if(!Talk::canList())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			$talks = Talk::select([
				'talks.id',
                'talks.user_id',
                'talks.location_id',
                'talks.title',
                'talks.youtube_url',
                'talks.rtmp_url',
                'talks.status',
			'talks.id as actions'
            ]);
			return Datatables::of($talks)
                ->edit_column('user_id', function($talk){
                	return $talk->user->name;
                })
                ->edit_column('location_id', function($talk){
                	return $talk->location->name;
                })
                ->edit_column('actions', function($talk){
                    $actions   = [];
                    $actions[] = $talk->canShow() ? link_to_action('TalksController@show', 'Show', $talk->id, ['class' => 'btn btn-xs btn-primary'] ) : '';
                    $actions[] = $talk->canUpdate() ? link_to_action('TalksController@edit', 'Update', $talk->id, ['class' => 'btn btn-xs btn-default'] ) : '';
                    $actions[] = $talk->canDelete() ? Former::open(action('TalksController@destroy', $talk->id))->class('form-inline') 
                    . Former::hidden('_method', 'DELETE')
                    . '<button type="button" class="btn btn-xs btn-danger confirm-delete">Delete</button>'
                    . Former::close() : '';
                    return implode(' ', $actions);
                })
                ->remove_column('id')
                ->make();
        }
        Asset::push('js', 'datatables');
        return View::make('talks.index');
    }

	/**
	 * Show the form for creating a new talk
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!Talk::canCreate())
		{
			return $this->_access_denied();
		}
		return View::make('talks.create');
	}

	/**
	 * Store a newly created talk in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
		Talk::setRules('store');
		if(!Talk::canCreate())
		{
			return $this->_access_denied();
		}
		$talk = new Talk;
		$talk->fill($data);
		if(!$talk->save())
		{
			return $this->_validation_error($talk);
		}
		if(Request::ajax())
		{
			return Response::json($talk, 201);
		}
		return Redirect::action('TalksController@index')
         ->with('notification:success', $this->created_message);
     }

	/**
	 * Display the specified talk.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$talk = Talk::findOrFail($id);
		if(!$talk->canShow())
		{
			return $this->_access_denied();
		}
		if(Request::ajax())
		{
			return Response::json($talk);
		}
		Asset::push('js', 'show');
		return View::make('talks.show', compact('talk'));
	}

	/**
	 * Show the form for editing the specified talk.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$talk = Talk::findOrFail($id);
		if(Request::ajax())
		{
			return $this->_ajax_denied();
		}
		if(!$talk->canUpdate())
		{
			return $this->_access_denied();
		}
		return View::make('talks.edit', compact('talk'));
	}

	/**
	 * Update the specified talk in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$talk = Talk::findOrFail($id);
		Talk::setRules('update');
		$data = Input::all();
		if(!$talk->canUpdate())
		{
			return $this->_access_denied();
		}
		if(!$talk->update($data)) {
			return $this->_validation_error($talk);
		}
		if(Request::ajax())
		{
			return $talk;
		}
		Session::remove('_old_input');
		return Redirect::action('TalksController@edit', $id)
            ->with('notification:success', $this->updated_message);
    }

	/**
	 * Remove the specified talk from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$talk = Talk::findOrFail($id);
		if(!$talk->canDelete())
		{
			return $this->_access_denied();
		}
		$talk->delete();
		if(Request::ajax())
		{
			return Response::json($this->deleted_message);
		}
		return Redirect::action('TalksController@index')
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
		View::share('controller', 'Talk');
	}

}
