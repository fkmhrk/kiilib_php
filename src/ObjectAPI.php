<?php

interface ObjectAPI {
	public function create($bucket, $data);
	
	public function update($object);

	public function delete($object);
}

?>