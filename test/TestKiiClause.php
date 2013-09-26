<?php
require_once (dirname(__FILE__) . '/../src/KiiClause.php');

class TestKiiClause extends PHPUnit_Framework_TestCase{
	private function assertAllClause($clause) {
		$this->assertEquals(1, count($clause));
		$this->assertEquals('all', $clause['type']);
	}
	
	public function test_0000_all() {
		$clause = KiiClause::all();
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(1, count($json));
		$this->assertEquals('all', $json['type']);
	}

	public function test_0010_and() {
		$clause = KiiClause::andClause(
									   KiiClause::all(), KiiClause::all());
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(2, count($json));
		$this->assertEquals('and', $json['type']);
		$clauses = $json['clauses'];
		$this->assertEquals(2, count($clauses));
		$this->assertAllClause($clauses[0]);
		$this->assertAllClause($clauses[1]);		
	}

	public function test_0011_and_array() {
		$a = array(KiiClause::all(),
				   KiiClause::all());
		$clause = KiiClause::andClause($a);
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(2, count($json));
		$this->assertEquals('and', $json['type']);
		$clauses = $json['clauses'];
		$this->assertEquals(2, count($clauses));
		$this->assertAllClause($clauses[0]);
		$this->assertAllClause($clauses[1]);		
	}

	public function test_0020_or() {
		$clause = KiiClause::orClause(
									   KiiClause::all(), KiiClause::all());
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(2, count($json));
		$this->assertEquals('or', $json['type']);
		$clauses = $json['clauses'];
		$this->assertEquals(2, count($clauses));
		$this->assertAllClause($clauses[0]);
		$this->assertAllClause($clauses[1]);		
	}

	public function test_0021_or_array() {
		$a = array(KiiClause::all(),
				   KiiClause::all());
		$clause = KiiClause::orClause($a);
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(2, count($json));
		$this->assertEquals('or', $json['type']);
		$clauses = $json['clauses'];
		$this->assertEquals(2, count($clauses));
		$this->assertAllClause($clauses[0]);
		$this->assertAllClause($clauses[1]);		
	}

	public function test_0030_not() {
		$clause = KiiClause::not(KiiClause::all());
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(2, count($json));
		$this->assertEquals('not', $json['type']);
		$clauses = $json['clause'];
		$this->assertAllClause($clauses);
	}

	public function test_0040_in() {
		$clause = KiiClause::inClause("age", array(1, 2, 3));
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(3, count($json));
		$this->assertEquals('in', $json['type']);
		$this->assertEquals('age', $json['field']);
		$values = $json['values'];
		$this->assertEquals(3, count($values));
		$this->assertEquals(1, $values[0]);
		$this->assertEquals(2, $values[1]);
		$this->assertEquals(3, $values[2]);	
	}

	public function test_0050_greaterThan_false() {
		$clause = KiiClause::greaterThan("age", 18, false);
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(4, count($json));
		$this->assertEquals('range', $json['type']);
		$this->assertEquals('age', $json['field']);		
		$this->assertEquals(18, $json['lowerLimit']);
		$this->assertFalse($json['lowerIncluded']);		
	}

	public function test_0051_greaterThan_true() {
		$clause = KiiClause::greaterThan("age", 18, true);
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(4, count($json));
		$this->assertEquals('range', $json['type']);
		$this->assertEquals('age', $json['field']);		
		$this->assertEquals(18, $json['lowerLimit']);
		$this->assertTrue($json['lowerIncluded']);		
	}

	public function test_0060_lessThan_false() {
		$clause = KiiClause::lessThan("age", 18, false);
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(4, count($json));
		$this->assertEquals('range', $json['type']);
		$this->assertEquals('age', $json['field']);		
		$this->assertEquals(18, $json['upperLimit']);
		$this->assertFalse($json['upperIncluded']);		
	}

	public function test_0061_lessThan_true() {
		$clause = KiiClause::lessThan("age", 18, true);
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(4, count($json));
		$this->assertEquals('range', $json['type']);
		$this->assertEquals('age', $json['field']);		
		$this->assertEquals(18, $json['upperLimit']);
		$this->assertTrue($json['upperIncluded']);		
	}

	public function test_0070_range_false() {
		$clause = KiiClause::range("age", 18, false, 60, false);
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(6, count($json));
		$this->assertEquals('range', $json['type']);
		$this->assertEquals('age', $json['field']);		
		$this->assertEquals(18, $json['lowerLimit']);
		$this->assertFalse($json['lowerIncluded']);
		$this->assertEquals(60, $json['upperLimit']);
		$this->assertFalse($json['upperIncluded']);		
	}

	public function test_0071_range_true() {
		$clause = KiiClause::range("age", 18, true, 60, true);
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(6, count($json));
		$this->assertEquals('range', $json['type']);
		$this->assertEquals('age', $json['field']);		
		$this->assertEquals(18, $json['lowerLimit']);
		$this->assertTrue($json['lowerIncluded']);
		$this->assertEquals(60, $json['upperLimit']);
		$this->assertTrue($json['upperIncluded']);		
	}

	public function test_0080_equals() {
		$clause = KiiClause::equals("age", 18);
		
		// assertion
		$json = $clause->toJson();
		$this->assertEquals(3, count($json));
		$this->assertEquals('eq', $json['type']);
		$this->assertEquals('age', $json['field']);		
		$this->assertEquals(18, $json['value']);
	}
}
?>