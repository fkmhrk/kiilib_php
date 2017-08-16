<?php

class KiiObject {
	private $bucket;
	private $id;
	public $data;
	public $version;

	public function __construct(KiiBucket $bucket, ?string $id, array $data)
    {
		$this->bucket = $bucket;
		$this->id = $id;
		$this->data = $data;
	}

	public function getId() : string
    {
		return $this->id;
	}

	public function getPath() : string
    {
		return $this->bucket->getPath().
			'/objects/'. $this->id;
	}
	
}

?>