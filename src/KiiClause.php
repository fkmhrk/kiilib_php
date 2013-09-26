<?php
class KiiClause {
	private $clause;
	
	private function __construct($type) {
		$this->clause = array('type' => $type);
	}

	public static function all() {
		return new KiiClause('all');
	}

	public static function equals($field, $value) {
		$c = new KiiClause('eq');
		$c->clause['field'] = $field;
		$c->clause['value'] = $value;
		
		return $c;		
	}
	
	public static function greaterThan($field, $value, $include) {
		$c = new KiiClause('range');
		$c->clause['field'] = $field;
		$c->clause['lowerLimit'] = $value;
		$c->clause['lowerIncluded'] = $include;		
		
		return $c;		
	}

	public static function lessThan($field, $value, $include) {
		$c = new KiiClause('range');
		$c->clause['field'] = $field;
		$c->clause['upperLimit'] = $value;
		$c->clause['upperIncluded'] = $include;		
		
		return $c;		
	}

	public static function range($field, $fromValue, $fromInclude,
								 $toValue, $toInclude) {
		$c = new KiiClause('range');
		$c->clause['field'] = $field;
		$c->clause['lowerLimit'] = $fromValue;
		$c->clause['lowerIncluded'] = $fromInclude;		
		$c->clause['upperLimit'] = $toValue;
		$c->clause['upperIncluded'] = $toInclude;		
		
		return $c;		
	}
	
	public static function inClause($field, array $values) {
		$c = new KiiClause('in');
		$c->clause['field'] = $field;
		$c->clause['values'] = $values;
		
		return $c;		
	}
	
	public static function not(KiiClause $clause) {
		$c = new KiiClause('not');
		$c->clause['clause'] = $clause->toJson();
		
		return $c;		
	}
	
	public static function andClause() {
		$c = new KiiClause('and');
		$array = KiiClause::toFlatArray(func_get_args());
		$c->clause['clauses'] = $array;
		
		return $c;
	}

	public static function orClause() {
		$c = new KiiClause('or');
		$array = KiiClause::toFlatArray(func_get_args());
		$c->clause['clauses'] = $array;

		return $c;		
	}
	
	private static function toFlatArray($args) {
		$array = array();
		foreach ($args as $arg) {
			if (is_array($arg)) {
				foreach ($arg as $a) {
					$array[]= $a->toJson();
				}
			} else {
				$array[]= $arg->toJson();
			}
		}
		return $array;
	}

	public function toJson() {
		return $this->clause;
	}
}

?>