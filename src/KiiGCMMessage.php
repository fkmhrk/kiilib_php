<?php

class KiiGCMMessage {
	public $data;
	private $enable;
	
	public function __construct() {
		$this->data = array();
		$this->enable = TRUE;
	}

	public function toJson() {
		$json = array(
					  "enabled" => $this->enable
					  );
		if (count($this->data) > 0) {
			$json['data'] = $this->data;
		}

		return $json;
	}
}
?>