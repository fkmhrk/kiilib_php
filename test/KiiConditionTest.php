<?php
require_once (dirname(__FILE__) . '/../src/KiiCondition.php');
require_once (dirname(__FILE__) . '/../src/KiiClause.php');

use PHPUnit\Framework\TestCase;

class TestKiiCondition extends TestCase {
	public function test_0000_all() {
		$condition = new KiiCondition(KiiClause::all());
		
		// assertion
		$json = $condition->toJson();
		$this->assertEquals(1, count($json));
		$json = $json['bucketQuery'];
		$this->assertEquals(1, count($json));
		$clause = $json['clause'];
		$this->assertEquals('all', $clause['type']);
	}

	public function test_0001_all_sortByAsc() {
		$condition = new KiiCondition(KiiClause::all());
		$condition->sortByAsc('_created');
		
		// assertion
		$json = $condition->toJson();
		$this->assertEquals(1, count($json));
		$json = $json['bucketQuery'];
		$this->assertEquals(3, count($json));
		$this->assertEquals('_created', $json['orderBy']);
		$this->assertEquals(FALSE, $json['descending']);
		$clause = $json['clause'];
		$this->assertEquals('all', $clause['type']);
	}	
}
?>