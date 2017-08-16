<?php
class CloudException extends Exception {
	private $status;
	private $resp;
	
	public function __construct(int $status, array $resp) {
		$this->status = $status;
		$this->resp = $resp;
	}

	public function getStatus() : int {
		return $this->status;
	}

	public function getResponse() : array {
		return $this->resp;
	}
}
?>