<?php

class KiiObject {
	private $bucket;
	private $id;
	public $data;
	public $version;

	public function __construct($bucket, $id, $data) {
		$this->bucket = $bucket;
		$this->id = $id;
		$this->data = $data;
	}

	public function getId() {
		return $this->id;
	}

	public function getPath() {
		return $this->bucket->getPath().
			'/objects/'. $this->id;
	}
	
}

?>