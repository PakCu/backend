<?php

class SMSCallbackController extends \BaseController {

	public function callback()
	{
		try {
			Log::info('incomming', Input::all());
			$phone = Input::get('msisdn');
			if(!$phone)
				return;
			$user = User::where('mobile_number', $phone)->first();
			if(!$user) {
				throw new MobileNumberNotFoundException;
			}
			$text = Input::get('text');
			$keyword = Input::get('keyword');
			if($keyword === 'CERAMAH') {
				$parts = explode(';', substr($text, 8));
				// $parts[0] => location_id, $parts[1] => ceramah title
				if(count($parts) !== 2) {
					throw new InvalidFormatException();
				}
				$location = Location::find($parts[0]);
				if(!$location) {
					throw new LocationNotFoundException();
				}

				$existing = Talk::where('user_id', $user->id)->where('status', '!=', 'Closed')->first();
				if($existing) {
					throw new AlreadyStreamingException();
				}

				$talk = Talk::create([
					'title' => ucwords($parts[1]),
					'location_id' => $location->id,
					'user_id' => $user->id,
				]);
				SMSService::StreamingReady($phone);
			} else if($keyword === 'BERHENTI') {
				$existing = Talk::where('user_id', $user->id)->where('status', '!=', 'Closed')->first();
				if(!$existing) {
					throw new NoActiveStreamException();
				}
				$existing->update(['status' => 'Closed']);
				SMSService::StreamClosed($phone, $existing->title);
			} else {
				throw new InvalidFormatException();
			}
		} catch (NoActiveStreamException $e) {
			SMSService::NoActiveStream($phone);
		}  catch (AlreadyStreamingException $e) {
			SMSService::AlreadyStreaming($phone, $existing->title);
		} catch (InvalidFormatException $e) {
			SMSService::InvalidFormat($phone);
		} catch (MobileNumberNotFoundException $e) {
			SMSService::MobileNumberNotRegistered($phone);
		} catch (LocationNotFoundException $e) {
			SMSService::LocationNotFound($phone, $parts[0]);
		}
	}

	public function __construct()
	{
		parent::__construct();
		View::share('controller', 'SMSCallback');
	}
}