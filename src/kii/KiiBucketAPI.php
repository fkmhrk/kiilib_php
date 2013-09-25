<?php
require_once (dirname(__FILE__) . '/../BucketAPI.php');
require_once (dirname(__FILE__) . '/../KiiContext.php');
require_once (dirname(__FILE__) . '/../CloudException.php');
require_once (dirname(__FILE__) . '/../KiiBucket.php');
require_once (dirname(__FILE__) . '/../KiiObject.php');

class KiiBucketAPI implements BucketAPI {
	private $context;

	public function __construct($context) {
		$this->context = $context;
	}

	public function query(KiiBucket $bucket, KiiCondition $condition) {
		$c = $this->context;
		$url = $c->getServerUrl().
			'/apps/'. $c->getAppId().
			$bucket->getPath().
			'/query';

		$client = $c->getNewClient();
		$client->setUrl($url);
		$client->setMethod(HttpClient::HTTP_POST);
		$client->setKiiHeader($c, TRUE);
		$client->setContentType('application/vnd.kii.QueryRequest+json');

		$resp = $client->sendJson($condition->toJson());
		if ($resp->getStatus() != 200) {
			throw new CloudException($resp->getStatus(), $resp->getAsJson());
		}
		$respJson = $resp->getAsJson();
		if (array_key_exists('nextPaginationKey', $respJson)) {
			$condition->setPaginationKey($respJson['nextPaginationKey']);
		} else {
			$condition->setPaginationKey(null);
		}

		$respArray = $respJson['results'];
		$result = array();
		foreach ($respArray as $item) {
			$id = $item['_id'];
			$result[]= new KiiObject($bucket, $id, $item);
		}
		
		return $result;
	}
}
?>