<?php
class KiiClause {
	private $clause;
	
	private function __construct($type) {
		$this->clause = array('type' => $type);
	}

	public static function all() {
		return new KiiClause('all');
	}

	public function toJson() {
		return $this->clause;
	}
}

?>