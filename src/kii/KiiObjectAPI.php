<?php
require_once (dirname(__FILE__) . '/../ObjectAPI.php');
require_once (dirname(__FILE__) . '/../KiiContext.php');
require_once (dirname(__FILE__) . '/../CloudException.php');
require_once (dirname(__FILE__) . '/../KiiBucket.php');
require_once (dirname(__FILE__) . '/../KiiObject.php');

class KiiObjectAPI implements ObjectAPI {
	private $context;

	public function __construct($context) {
		$this->context = $context;
	}
	
	public function create($bucket, $data) {
		$c = $this->context;
		$url = $c->getServerUrl().
			'/apps/'. $c->getAppId().
			$bucket->getPath(). 
			'/objects';

		$client = $c->getNewClient();
		$client->setUrl($url);
		$client->setMethod(HttpClient::HTTP_POST);
		$client->setKiiHeader($c, TRUE);
		$client->setContentType('application/json');

		$resp = $client->sendJson($data);
		if ($resp->getStatus() != 201) {
			throw new CloudException($resp->getStatus(), $resp->getAsJson());
		}
		$respJson = $resp->getAsJson();
		$id = $respJson['objectID'];
		
		return new KiiObject($bucket, $id, $data);
	}

	public function update($object) {
		$c = $this->context;
		$url = $c->getServerUrl().
			'/apps/'. $c->getAppId().
			$object->getPath();

		$client = $c->getNewClient();
		$client->setUrl($url);
		$client->setMethod(HttpClient::HTTP_PUT);
		$client->setKiiHeader($c, TRUE);
		$client->setContentType('application/json');

		$resp = $client->sendJson($object->data);
		if ($resp->getStatus() == 200) {
			$respJson = $resp->getAsJson();
			return $object;
		} else if ($resp->getStatus() == 201) {
			return $object;
		}
		throw new CloudException($resp->getStatus(), $resp->getAsJson());
	}

	public function delete($object) {
		$c = $this->context;
		$url = $c->getServerUrl().
			'/apps/'. $c->getAppId().
			$object->getPath();

		$client = $c->getNewClient();
		$client->setUrl($url);
		$client->setMethod(HttpClient::HTTP_DELETE);
		$client->setKiiHeader($c, TRUE);

		$resp = $client->send();
		if ($resp->getStatus() != 204) {
			throw new CloudException($resp->getStatus(), $resp->getAsJson());
		}
	}
}

?>