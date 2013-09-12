<?php
require_once 'HTTP/Request2.php';
require_once 'KiiHttpResponse.php';
class KiiHttpClient {
	const HTTP_GET = 1;
	const HTTP_POST = 2;
	const HTTP_PUT = 3;
	const HTTP_DELETE = 4;
	private $context;
	private $req;

	public function __construct($context, $method, $path, $authRequired) {
		if (empty($context)) {
			throw new RuntimeException('context must not be null');
		}
		$this->context = $context;
		$this->req = new HTTP_Request2($context->getServerUrl(). $path);
		$this->req->setMethod($this->toMethod($method))
			->setHeader('x-kii-appid', $context->getAppId())
			->setHeader('x-kii-appkey', $context->getAppKey())
			->setConfig('ssl_verify_host', false)
			->setConfig('ssl_verify_peer', false);
		if ($authRequired) {
			$this->req->setHeader('Authorization',
								  'Bearer '. $context->getToken());
		}
	}
	public function setContentType($value) {
		$this->req->setHeader('content-type', $value);
	}

	public function sendJson($str) {
		// check empty json
		if (count($str) == 0) {
			$body = '{}';
		} else {
			$body = json_encode($str);
		}
		$this->req->setBody($body);
		return $this->send();
	}
	public function send() {
		$resp = $this->req->send();
		return new KiiHttpResponse($resp->getStatus(), $resp->getBody());
	}
	private function toMethod($method) {
		switch ($method) {
		case KiiHttpClient::HTTP_GET: return HTTP_Request2::METHOD_GET;
		case KiiHttpClient::HTTP_POST: return HTTP_Request2::METHOD_POST;
		case KiiHttpClient::HTTP_PUT: return HTTP_Request2::METHOD_PUT;
		case KiiHttpClient::HTTP_DELETE: return HTTP_Request2::METHOD_DELETE;
		}
		return HTTP_Request2::METHOD_POST;
	}
}
?>