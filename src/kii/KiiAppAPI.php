<?php
require_once (dirname(__FILE__) . '/../AppAPI.php');
require_once (dirname(__FILE__) . '/../KiiContext.php');
require_once (dirname(__FILE__) . '/../CloudException.php');
require_once (dirname(__FILE__) . '/../KiiUser.php');
require_once (dirname(__FILE__) . '/../KiiApp.php');

require_once (dirname(__FILE__) . '/KiiUserAPI.php');
require_once (dirname(__FILE__) . '/KiiGroupAPI.php');
require_once (dirname(__FILE__) . '/KiiBucketAPI.php');
require_once (dirname(__FILE__) . '/KiiObjectAPI.php');
require_once (dirname(__FILE__) . '/KiiTopicAPI.php');
							   
class KiiAppAPI implements AppAPI {
	private $context;

	private $userAPI;
	private $groupAPI;
	private $bucketAPI;
	private $objectAPI;	
	private $topicAPI;

	public function __construct($context) {
		$this->context = $context;

		$this->userAPI = new KiiUserAPI($context);
		$this->groupAPI = new KiiGroupAPI($context);
		$this->bucketAPI = new KiiBucketAPI($context);
		$this->objectAPI = new KiiObjectAPI($context);
		$this->topicAPI = new KiiTopicAPI($context);
	}
	
	public function login($userIdentifier, $password) {
		$body = array(
					  'username' => $userIdentifier,
					  'password' => $password
					  );
		return $this->execLogin($body);
	}

	public function loginAsAdmin($clientId, $clientSecret) {
		$body = array(
					  'client_id' => $clientId,
					  'client_secret' => $clientSecret
					  );
		return $this->execLogin($body);
	}

	private function execLogin($body) {
		$c = $this->context;
		$url = $c->getServerUrl(). '/oauth2/token';
		
		$client = $c->getNewClient();
		$client->setUrl($url);
		$client->setMethod(HttpClient::HTTP_POST);
		$client->setKiiHeader($c, FALSE);
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
		return $this->userAPI;
	}

	public function groupAPI() {
		return $this->groupAPI;
	}
	
	public function bucketAPI() {
		return $this->bucketAPI;
	}
	
	public function objectAPI(){
		return $this->objectAPI;
	}
	
	public function aclAPI() {
	}

	public function topicAPI() {
		return $this->topicAPI;
	}
}
?>