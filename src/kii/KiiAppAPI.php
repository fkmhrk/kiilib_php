<?php
require_once (dirname(__FILE__) . '/../AppAPI.php');
require_once (dirname(__FILE__) . '/../KiiContext.php');
require_once (dirname(__FILE__) . '/../CloudException.php');
require_once (dirname(__FILE__) . '/../KiiUser.php');

require_once (dirname(__FILE__) . '/KiiGroupAPI.php');
require_once (dirname(__FILE__) . '/KiiObjectAPI.php');
require_once (dirname(__FILE__) . '/KiiTopicAPI.php');
							   
class KiiAppAPI implements AppAPI {
	private $context;
	private $groupAPI;
	private $objectAPI;	
	private $topicAPI;

	public function __construct($context) {
		$this->context = $context;

		$this->groupAPI = new KiiGroupAPI($context);
		$this->objectAPI = new KiiObjectAPI($context);
		$this->topicAPI = new KiiTopicAPI($context);
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
	}

	public function groupAPI() {
		return $this->groupAPI;
	}
	
	public function bucketAPI() {
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