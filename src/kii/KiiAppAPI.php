<?php
require_once (dirname(__FILE__) . '/../AppAPI.php');
require_once (dirname(__FILE__) . '/../KiiContext.php');
require_once (dirname(__FILE__) . '/../CloudException.php');
require_once (dirname(__FILE__) . '/../KiiUser.php');

require_once (dirname(__FILE__) . '/KiiGroupAPI.php');
							   
class KiiAppAPI implements AppAPI {
	private $context;
	private $groupAPI;

	public function __construct($context) {
		$this->context = $context;

		$this->groupAPI = new KiiGroupAPI($context);
	}
	
	public function login($userIdentifier, $password) {
		$c = $this->context;
		$url = $c->getServerUrl(). '/oauth2/token';
		$body = array(
					  'username' => $userIdentifier,
					  'password' => $password
					  );
		$client = $c->getNewClient();
		$client->setUrl($url);
		$client->setMethod(HttpClient::HTTP_POST);
		$client->setHeader('x-kii-appid', $c->getAppId());
		$client->setHeader('x-kii-appkey', $c->getAppKey());
		$client->setContentType('application/json');

		$resp = $client->sendJson($body);
		if ($resp->getStatus() != 200) {
			throw new CloudException($resp->getStatus(), $resp->getAsJson());
		}
		$respJson = $resp->getAsJson();

		$userId = $respJson['id'];
		$token = $respJson['access_token'];
		$c->setAccessToken($token);

		return new Kiiuser($userId);
	}
	
	// APIs
	public function userAPI() {
	}

	public function groupAPI() {
		return $this->groupAPI;
	}
	
	public function bucketAPI() {
	}
	
	public function objectAPI(){
	}
	
	public function aclAPI() {
	}
}
?>