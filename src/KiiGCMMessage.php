<?php

class KiiGCMMessage {
	public $data;
	private $enable;
	
	public function __construct()
    {
		$this->data = array();
		$this->enable = TRUE;
	}

	public function setEnabled(bool $value)
    {
		$this->enable = $value;
	}

	public function toJson() : array
    {
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