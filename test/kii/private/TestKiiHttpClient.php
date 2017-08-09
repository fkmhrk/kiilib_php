<?php
require '../../../src/kii/private/KiiHttpClient.php';

use PHPUnit\Framework\TestCase;

class TestKiiHttpClient extends TestCase {
	public function test_0000_get_request() {
		$client = new KiiHttpClient();
		$client->setUrl('http://example.com/');
		$client->setMethod(HttpClient::HTTP_GET);
		$ret = $client->send();
		// assertion
		$this->assertEquals(200, $ret->getStatus());
	}

	public function test_0001_get_404() {
		$client = new KiiHttpClient();
		$client->setUrl('https://api.kii.com/api/apps/dummy');
		$client->setMethod(HttpClient::HTTP_GET);
		$ret = $client->send();
		// assertion
		$this->assertEquals(404, $ret->getStatus());
		$json = $ret->getAsJson();
		$this->assertEquals('4', count($json));
		$this->assertEquals('dummy', $json['appID']);
	}
	
	public function test_0100_post_404() {
		$client = new KiiHttpClient();
		$client->setUrl('https://api.kii.com/api/apps/dummy');
		$client->setHeader('x-kii-appid', 'dummy');
		$client->setHeader('x-kii-appkey', 'dummy');
		$client->setMethod(HttpClient::HTTP_POST);
		$ret = $client->send();
		// assertion
		$this->assertEquals(401, $ret->getStatus());
		$json = $ret->getAsJson();
		$this->assertEquals('0', count($json));
	}		
}
?>