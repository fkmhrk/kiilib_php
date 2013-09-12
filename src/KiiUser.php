<?php
class KiiUser {
	private $id;

	public function __construct($id) {
		$this->id = $id;
	}

	public function getPath() {
		return '/users/' . $this->id;
	}
}
?>