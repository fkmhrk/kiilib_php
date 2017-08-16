<?php
require_once dirname(__FILE__). '/../../HttpClient.php';
require_once dirname(__FILE__). '/KiiHttpResponse.php';
require_once (dirname(__FILE__). '/KiiHttpClientObserver.php');
							  
require_once 'HTTP/Request2.php';
class KiiHttpClient implements HttpClient {
	private $req;
	
	public function __construct() {
		$this->req = new HTTP_Request2();
		$this->req->setConfig('ssl_verify_peer', false);
	}
	
	public function setUrl(string $url) {
		$this->req->setUrl($url);
		return $this;
	}

	public function setMethod(int $method) {
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
	
	public function setContentType(string $value) {
		$this->setHeader('content-type', $value);
	}

	public function setHeader(string $key, string $value) {
		$this->req->setHeader($key, $value);
	}

	public function setKiiHeader(KiiContext $context, bool $authRequired) {
		$this->setHeader('x-kii-appid', $context->getAppId());
		$this->setHeader('x-kii-appkey', $context->getAppKey());
		if ($authRequired) {
			$this->setHeader('authorization',
							 'bearer '. $context->getAccessToken());
		}
	}

	public function sendFile($fp) {
		$this->req->setBody($fp);
		return $this->send();
	}

	public function sendForDownload($fp) {
		$this->req->attach(new KiiHttpClientObserver($fp));
		return $this->send();
	}
		
	public function sendJson(array $json) {
		$body = json_encode($json);
		$this->req->setBody($body);
		return $this->send();
	}

	public function send() {
		try {
			$resp = $this->req->send();
			return new KiiHttpResponse($resp->getStatus(),
									   $resp->getHeader(),
									   $resp->getBody());
		} catch (HTTP_Request2_Exception $e) {
			print_r($e);
		}
	}
}
?>