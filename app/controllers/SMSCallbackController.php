<?php

class SMSCallbackController extends \BaseController {

	public function callback()
	{
		try {
			$phone = Input::get('msisdn');
			if(!$phone)
				return;
			$user = User::where('phone_number', $phone)->first();
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

				$talk = Talk::create([
					'title' => ucwords($parts[1]),
					'location_id' => $location->id,
					'user_id' => $user->id,
				]);
			} else {
				throw new InvalidFormatException();
			}
		} catch (InvalidFormatException $e) {
			SMSService::InvalidFormat($phone);
		}  catch (MobileNumberNotFoundException $e) {
			SMSService::MobileNumberNotRegistered($phone);
		} catch (LocationNotFoundException $e) {
			SMSService::LocationNotFound($phone, $parts[0]);
		}
	}

	public function __construct()
	{
		__parent::construct();
		View::share('controller', 'SMSCallback');
	}
}