<?php
require_once (dirname(__FILE__) . '/../TopicAPI.php');
require_once (dirname(__FILE__) . '/../KiiContext.php');
require_once (dirname(__FILE__) . '/../CloudException.php');

class KiiTopicAPI implements TopicAPI {
	private $context;

	public function __construct($context) {
		$this->context = $context;
	}

	public function create(KiiTopic $topic) {
		$c = $this->context;
		$url = $c->getServerUrl().
			'/apps/'. $c->getAppId().
			$topic->getPath();
		$client = $c->getNewClient();
		$client->setUrl($url);
		$client->setMethod(HttpClient::HTTP_PUT);
		$client->setKiiHeader($c, TRUE);

		$resp = $client->send();
		if ($resp->getStatus() != 204) {
			throw new CloudException($resp->getStatus(), $resp->getAsJson());
		}			
	}
	
	public function sendMessage(KiiTopic $topic, KiiTopicMessage $message) {
		$c = $this->context;
		$url = $c->getServerUrl().
			'/apps/'. $c->getAppId().
			$topic->getPath(). 
			'/push/messages';
		$body = $message->toJson();

		$client = $c->getNewClient();
		$client->setUrl($url);
		$client->setMethod(HttpClient::HTTP_POST);
		$client->setKiiHeader($c, TRUE);
		$client->setContentType('application/vnd.kii.SendPushMessageRequest+json');

		$resp = $client->sendJson($body);
		if ($resp->getStatus() != 201) {
			throw new CloudException($resp->getStatus(), $resp->getAsJson());
		}
		$respJson = $resp->getAsJson();
		return $respJson['pushMessageID'];
	}
}

?>