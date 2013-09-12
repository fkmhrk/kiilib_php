<?php
require_once dirname(__FILE__). '/../../src/HttpClient.php';
							  
class MockHttpClient implements HttpClient {
	private $sendQueue;

	public function __construct() {
		$this->sendQueue = array();
	}
	
	public function setUrl($url) {
	}

	public function setMethod($method) {
	}
	
	public function setContentType($value) {
	}

	public function setHeader($key, $value) {
	}

	public function setKiiHeader($context, $authRequired) {
	}
		
	public function sendJson($json) {
		return array_pop($this->sendQueue);
	}

	public function send() {
		return array_pop($this->sendQueue);
	}

	public function addToSend($value) {
		array_push($this->sendQueue, $value);
	}
}
?>