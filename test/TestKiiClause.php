<?php
require_once (dirname(__FILE__) . '/../src/KiiClause.php');

class TestKiiClause extends PHPUnit_Framework_TestCase{
	public function test_0000_all() {
		$clause = KiiClause::all();
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(1, count($json));
		$this->assertEquals('all', $json['type']);
	}
}
?>