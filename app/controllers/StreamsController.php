<?php

class StreamsController extends \BaseController {

	public function start()
	{
		$hash = Input::get('hash');
		$location = Location::where('hash', $hash)->first();
		if(!$location)
			throw new LocationNotFoundException();
		$talk = $location->talks()->where('status', 'Awaiting Pairing')->first();
		if(!$talk)
			throw new TalkNotFoundException();
		$talk->update(['status' => 'Polling Readiness']);
		return $talk->rtmp_url;
	}

	public function stop()
	{
		$hash = Input::get('hash');
		$location = Location::where('hash', $hash)->first();
		if(!$location)
			throw new LocationNotFoundException();
		$talk = $location->talks()->where('status', '!=', 'Closed')->first();
		if(!$talk)
			throw new TalkNotFoundException();
		$talk->update(['status' => 'Closed']);
		return 'ok';
	}

	public function __construct()
	{
		parent::__construct();
		View::share('controller', 'Streams');
	}

}