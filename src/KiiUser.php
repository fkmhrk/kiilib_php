<?php
class KiiUser {
	private $id;
	public $data;

	public function __construct(string $id)
    {
		$this->id = $id;
	}

	public function getId() : string
    {
		return $this->id;
	}
	
	public function getPath() : string
    {
		return '/users/' . $this->id;
	}
}
?>