<?php

class StreamsController extends \BaseController {

	public function getStart()
	{
		$device_hash = Input::get('device_hash');
		$location = Location::where('device_hash', $device_hash)->first();
		if(!$location)
			throw new LocationNotFoundException();
		$talk = $location->talks()->where('status', 'Awaiting Pairing')->first();
		if(!$talk)
			throw new TalkNotFoundException();
		$talk->update(['status' => 'Polling Readiness']);
		return $talk->rtmp_url;
	}

	public function getStop()
	{
		$device_hash = Input::get('device_hash');
		$location = Location::where('device_hash', $device_hash)->first();
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