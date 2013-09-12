<?php
class KiiGroup {
	private $id;

	public function __construct($id) {
		$this->id = $id;
	}

	public function getPath() {
		return '/groups/'. $this->id;
	}
}

?>