<?php
class KiiUser {
	private $id;
	public $data;

	public function __construct($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}
	
	public function getPath() {
		return '/users/' . $this->id;
	}
}
?>