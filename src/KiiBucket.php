<?php

class KiiBucket {
	private $owner;
	private $name;

	public function __construct($owner, $name) {
		$this->owner = $owner;
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function getPath() {
		return $this->owner->getPath().
			'/buckets/'. $this->name;
	}
}

?>