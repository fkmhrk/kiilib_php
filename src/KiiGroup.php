<?php
class KiiGroup {
	private $id;

	public function __construct(string $id)
    {
		$this->id = $id;
	}

	public function getPath() : string
    {
		return '/groups/'. $this->id;
	}
}

?>