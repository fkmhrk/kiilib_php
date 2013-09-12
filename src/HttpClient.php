<?php
interface HttpClient {
	const HTTP_GET = 1;
	const HTTP_POST = 2;
	const HTTP_PUT = 3;
	const HTTP_DELETE = 4;

	public function setUrl($url);

	public function setMethod($method);
	
	public function setContentType($value);

	public function setHeader($key, $value);

	public function setKiiHeader($context, $authRequired);

	public function sendJson($json);

	public function send();

}
?>