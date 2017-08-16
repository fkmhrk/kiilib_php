<?php
require_once (dirname(__FILE__). '/KiiContext.php');
interface HttpClient {
	const HTTP_GET = 1;
	const HTTP_POST = 2;
	const HTTP_PUT = 3;
	const HTTP_DELETE = 4;

	public function setUrl(string $url);

	public function setMethod(int $method);
	
	public function setContentType(string $value);

	public function setHeader(string $key, string $value);

	public function setKiiHeader(KiiContext $context, bool $authRequired);

	public function sendFile($fp);

	public function sendForDownload($fp);
	
	public function sendJson(array $json);

	public function send();

}
?>