<?php
require_once dirname(__FILE__). '/../../HttpResponse.php';
							  
class KiiHttpResponse implements HttpResponse {
	private $status;
	private $body;

	public function __construct($status, $body) {
		$this->status = $status;
		$this->body = $body;
	}

	public function getStatus() {
		return $this->status;
	}
	
	public function getAsJson() {
		return json_decode($this->body, TRUE);
	}
}
?>