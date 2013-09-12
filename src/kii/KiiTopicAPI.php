<?php
require_once (dirname(__FILE__) . '/../TopicAPI.php');
require_once (dirname(__FILE__) . '/../KiiContext.php');
require_once (dirname(__FILE__) . '/../CloudException.php');
require_once (dirname(__FILE__) . '/../KiiTopic.php');
require_once (dirname(__FILE__) . '/../KiiTopicMessage.php');

class KiiTopicAPI implements TopicAPI {
	private $context;

	public function __construct($context) {
		$this->context = $context;
	}
	
	public function sendMessage($topic, $message) {
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