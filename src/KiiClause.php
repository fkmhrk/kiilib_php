<?php
class KiiClause {
	private $clause;
	
	private function __construct(string $type)
    {
		$this->clause = array('type' => $type);
	}

	public static function all() : KiiClause
    {
		return new KiiClause('all');
	}

	public static function equals(string $field, $value) : KiiClause
    {
		$c = new KiiClause('eq');
		$c->clause['field'] = $field;
		$c->clause['value'] = $value;
		
		return $c;		
	}
	
	public static function greaterThan(string $field, $value, bool $include) 
        : KiiClause
    {
		$c = new KiiClause('range');
		$c->clause['field'] = $field;
		$c->clause['lowerLimit'] = $value;
		$c->clause['lowerIncluded'] = $include;		
		
		return $c;		
	}

	public static function lessThan(string $field, $value, bool $include)
        : KiiClause
    {
		$c = new KiiClause('range');
		$c->clause['field'] = $field;
		$c->clause['upperLimit'] = $value;
		$c->clause['upperIncluded'] = $include;		
		
		return $c;		
	}

	public static function range(string $field, $fromValue, bool $fromInclude,
								 $toValue, bool $toInclude) : KiiClause
    {
		$c = new KiiClause('range');
		$c->clause['field'] = $field;
		$c->clause['lowerLimit'] = $fromValue;
		$c->clause['lowerIncluded'] = $fromInclude;		
		$c->clause['upperLimit'] = $toValue;
		$c->clause['upperIncluded'] = $toInclude;		
		
		return $c;		
	}
	
	public static function inClause(string $field, array $values) : KiiClause 
    {
		$c = new KiiClause('in');
		$c->clause['field'] = $field;
		$c->clause['values'] = $values;
		
		return $c;		
	}
	
	public static function not(KiiClause $clause) : KiiClause
    {
		$c = new KiiClause('not');
		$c->clause['clause'] = $clause->toJson();
		
		return $c;		
	}
	
	public static function andClause() : KiiClause
    {
		$c = new KiiClause('and');
		$array = KiiClause::toFlatArray(func_get_args());
		$c->clause['clauses'] = $array;
		
		return $c;
	}

	public static function orClause() : KiiClause 
    {
		$c = new KiiClause('or');
		$array = KiiClause::toFlatArray(func_get_args());
		$c->clause['clauses'] = $array;

		return $c;		
	}
	
	private static function toFlatArray(array $args) : array 
    {
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

	public function toJson() : array
    {
		return $this->clause;
	}
}

?>