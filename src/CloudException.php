<?php
class CloudException extends Exception {
	private $status;
	private $resp;
	
	public function __construct($status, $resp) {
		$this->status = $status;
		$this->resp = $resp;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getResponse() {
		return $this->resp;
	}
}
?>