<?php
class KiiTopic {
	private $owner;
	private $name;

	public function __construct($owner, string $name)
    {
		$this->owner = $owner;
		$this->name = $name;
	}

	public function getName() : string
    {
		return $this->name;
	}

	public function getPath() : string
    {
		return $this->owner->getPath().
			'/topics/'. $this->name;
	}
	
}

?>