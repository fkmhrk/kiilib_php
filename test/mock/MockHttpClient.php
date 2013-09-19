<?php
require_once dirname(__FILE__). '/../../src/HttpClient.php';
							  
class MockHttpClient implements HttpClient {
	public $urlArgs;
	public $sendJsonArgs;
	private $sendQueue;
	private $downloadQueue;
	
	public function __construct() {
		$this->urlArgs = array();
		$this->sendJsonArgs = array();
		$this->sendQueue = array();
		$this->downloadQueue = array();
	}
	
	public function setUrl($url) {
		array_push($this->urlArgs, $url);
	}

	public function setMethod($method) {
	}
	
	public function setContentType($value) {
	}

	public function setHeader($key, $value) {
	}

	public function setKiiHeader($context, $authRequired) {
	}

	public function sendFile($fp) {
		return array_pop($this->sendQueue);		
	}

	public function sendForDownload($fp) {
		$text = array_pop($this->downloadQueue);
		fwrite($fp, $text);
		return $this->send();
	}
	
	public function sendJson($json) {
		array_push($this->sendJsonArgs, $json);
		return array_pop($this->sendQueue);
	}

	public function send() {
		return array_pop($this->sendQueue);
	}

	public function addToSend($value) {
		array_push($this->sendQueue, $value);
	}
	
	public function addToSendForDownload($value) {
		array_push($this->downloadQueue, $value);
	}	
}
?>