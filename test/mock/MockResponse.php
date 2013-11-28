<?php
require_once (dirname(__FILE__). '/../../src/HttpResponse.php');

class MockResponse implements HttpResponse {
	private $status;
	private $headers;
	private $body;

	public function __construct($status, $headers, $body) {
		$this->status = $status;
		$this->headers = $headers;
		$this->body = $body;
	}
	
	public function getStatus() {
		return $this->status;
	}

	public function getAllHeaders() {
		return $this->headers;
	}

	public function getAsJson() {
		return json_decode($this->body, TRUE);
	}
}
?>