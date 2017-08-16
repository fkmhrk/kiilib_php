<?php
require_once dirname(__FILE__). '/../../HttpResponse.php';
							  
class KiiHttpResponse implements HttpResponse {
	private $status;
	private $headers;
	private $body;

	public function __construct(int $status, array $headers, array $body)
    {
		$this->status = $status;
		$this->headers = $headers;
		$this->body = $body;
	}

	public function getStatus() : int
    {
		return $this->status;
	}

	public function getAllHeaders() : array
    {
		return $this->headers;
	}
	
	public function getAsJson() : array {
		return json_decode($this->body, TRUE);
	}
}
?>