<?php namespace Lamarus\Stormpath\Providers;

use Illuminate\Auth\UserProviderInterface;
use Illuminate\Auth\GenericUser;
use Guzzle\Http\Client;
use Config;

class StormpathUserProvider implements UserProviderInterface {

	private $client;
	private $tenants;

	public function __construct()
	{
		$this->client = new Client('https://api.stormpath.com/v1',array(
            'request.options' => array(
                'auth'    => array(Config::get('stormpath::id'), Config::get('stormpath::secret'), 'Basic')
            )
        ));

        $this->tenants = $this->client->get('tenants/current')->send()->json();
	}

	public function retrieveById($identifier) 
	{
		return new \Lamarus\Stormpath\StormpathUser('https://api.stormpath.com/v1/accounts/'.$identifier);
	}

	public function retrieveByCredentials(array $credentials) 
	{
		$bytes = utf8_encode($credentials['username'].':'.$credentials['password']);
		$string = base64_encode($bytes);

		$applicationId = Config::get('stormpath::applicationId');

		$request = $this->client->post("applications/{$applicationId}/loginAttempts");
		$request->setHeader('Accept','application/json');
		$request->setBody(json_encode(
			array(
				'type'=>'basic',
				'value'=>$string
				)
			), 'application/json');

		$response = $request->send()->json();
		
		$user = $response['account']['href'];

		return new \Lamarus\Stormpath\StormpathUser($user);
	}

	public function validateCredentials(\Illuminate\Auth\UserInterface $user, array $credentials)
	{
		$request = $this->client->get($user->getAuthIdentifier());
		$response = json_encode($request->send()->json());

		return true;
	}

}

//curl --user 1YSLFPTKGIUG1MURR6V2Q04RH:jfX0fBPf+w5/sfHs54mUh3RYqT1zUaBfHv1nv26unGI -H "Accept: application/json" -H "Content-Type: application/json" -d '{"type": "basic", "value":"dGVzdEB0ZXN0LmNvbToxMjM0QWJjZA=="}' https://api.stormpath.com/v1/applications/6ewhbPEUJDUzOqj8DV4Ahn/loginAttempts