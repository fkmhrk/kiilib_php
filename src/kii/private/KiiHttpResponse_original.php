<?php
class KiiHttpResponse {
	private $code;
	private $body;

	public function __construct($code, $body) {
		$this->code = $code;
		$this->body = $body;
	}

	public function getCode() {
		return $this->code;
	}
	public function toJson() {
		return json_decode($this->body);
	}
}
?>