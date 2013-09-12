<?php
require_once (dirname(__FILE__) . '/../GroupAPI.php');
require_once (dirname(__FILE__) . '/../KiiContext.php');
require_once (dirname(__FILE__) . '/../CloudException.php');
require_once (dirname(__FILE__) . '/../KiiUser.php');
require_once (dirname(__FILE__) . '/../KiiGroup.php');

class KiiGroupAPI implements GroupAPI {
	private $context;

	public function __construct($context) {
		$this->context = $context;
	}
	
	public function getJoinedGroups($user) {
		return $this->getGroups($user, 'is_member');
	}

	private function getGroups($user, $q) {
		$c = $this->context;
		$url = $c->getServerUrl().
			'/apps/'. $c->getAppId().
			'/groups?'. $q. '='. $user->getId();
		
		$client = $c->getNewClient();
		$client->setUrl($url);
		$client->setMethod(HttpClient::HTTP_GET);
		$client->setKiiHeader($c, TRUE);

		$resp = $client->send();
		if ($resp->getStatus() != 200) {
			throw new CloudException($resp->getStatus(), $resp->getAsJson());
		}
		
		$result = array();
		$respJson = $resp->getAsJson();
		$respGroups = $respJson['groups'];
		foreach ($respGroups as $respGroup) {
			array_push($result, $this->toKiiGroup($respGroup));
		}
		return $result;		
	}

	private function toKiiGroup($respGroup) {
		$id = $respGroup['groupID'];
		$name = $respGroup['name'];
		$ownerId = $respGroup['owner'];

		return new KiiGroup($id);
	}
}

?>