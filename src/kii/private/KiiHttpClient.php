<?php
require_once dirname(__FILE__). '/../../HttpClient.php';
require_once dirname(__FILE__). '/KiiHttpResponse.php';
							  
require_once 'HTTP/Request2.php';
class KiiHttpClient implements HttpClient {
	private $req;
	
	public function __construct() {
		$this->req = new HTTP_Request2();
	}
	
	public function setUrl($url) {
		$this->req->setUrl($url);
		return $this;
	}

	public function setMethod($method) {
		switch ($method) {
		case HttpClient::HTTP_GET:
			$this->req->setMethod(HTTP_Request2::METHOD_GET);
			break;
		case HttpClient::HTTP_POST:
			$this->req->setMethod(HTTP_Request2::METHOD_POST);
			break;
		case HttpClient::HTTP_PUT:
			$this->req->setMethod(HTTP_Request2::METHOD_PUT);
			break;
		case HttpClient::HTTP_DELETE:
			$this->req->setMethod(HTTP_Request2::METHOD_DELETE);
			break;
		}		
	}
	
	public function setContentType($value) {
	}

	public function setHeader($key, $value) {
		$this->req->setHeader($key, $value);
	}

	public function sendJson($json) {
	}

	public function send() {
		try {
			$resp = $this->req->send();
			return new KiiHttpResponse($resp->getStatus(), $resp->getBody());
		} catch (HTTP_Request2_Exception $e) {
		}
	}
}
?>