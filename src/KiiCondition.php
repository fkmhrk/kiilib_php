<?php
require_once (dirname(__FILE__). '/KiiClause.php');
class KiiCondition {
	private $clause;
	private $orderBy;
	private $descending;
	private $limit;
	private $paginationKey;

	public function __construct($clause) {
		$this->clause = $clause;
	}

	public function sortByAsc($field) {
		$this->orderBy = $field;
		$this->descending = FALSE;
	}

	public function sortByDesc($field) {
		$this->orderBy = $field;
		$this->descending = TRUE;
	}

	public function setLimit($limit) {
		$this->limit = $limit;
	}

	public function setPaginationKey($key) {
		$this->paginationKey = $key;
	}

	public function hasNext() {
		return $this->paginationKey != null;
	}

	public function toJson() {
		$query = array(
					   'clause' => $this->clause->toJson()
					   );
		if (isset($this->orderBy)) {
			$query['orderBy'] = $this->orderBy;
			$query['descending'] = $this->descending;
		}
		$json = array('bucketQuery' => $query);
		if (isset($this->limit)) {
			$json['bestEffortLimit'] = $this->limit;
		}
		if (isset($this->paginationKey)) {
			$json['paginationKey'] = $this->paginationKey;
		}
		
		return $json;
	}
}
?>