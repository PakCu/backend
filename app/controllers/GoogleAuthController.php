<?php

class GoogleAuthController extends \BaseController {

	protected $client;
	protected $refreshTokenFile;

	public function getStatus()
	{
		if(file_exists($this->refreshTokenFile)) {
			$this->client->refreshToken(file_get_contents($this->refreshTokenFile));
		}
		if(!$this->client->getAccessToken()) {
			$url = $this->client->createAuthUrl();
			return Redirect::to($url);
		}
		return View::make('google.status');
	}

	public function getCallback()
	{
		$this->client->authenticate($_GET['code']);
		file_put_contents($this->refreshTokenFile, $this->client->getRefreshToken());
		return Redirect::action('GoogleAuthController@getStatus');
	}

	public function getRevoke()
	{
		if(file_exists($this->refreshTokenFile)) {
			unlink($this->refreshTokenFile);
		}
		return Redirect::to('/')->with('notification:warning', 'Access Token Revoked');
	}

	public function __construct()
	{
		$client = $this->client = new Google_Client();
		$client->setClientId(getenv('GOOGLE_CLIENT_ID'));
		$client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
		$client->setScopes('https://www.googleapis.com/auth/youtube');
		$client->setRedirectUri(getenv('GOOGLE_REDIRECT_URL'));
		$client->setAccessType("offline");
		$client->setPrompt("consent");
		$this->refreshTokenFile = storage_path() . '/.google-refresh-token';
		parent::__construct();
		View::share('controller', 'GoogleAuthController');
	}

}