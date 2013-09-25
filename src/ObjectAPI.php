<?php
require_once (dirname(__FILE__). '/KiiBucket.php');
require_once (dirname(__FILE__). '/KiiObject.php');
interface ObjectAPI {
	public function create(KiiBucket $bucket, $data);
	
	public function update(KiiObject $object);

	public function delete(KiiObject $object);

	public function updateBody(KiiObject $object, $contentType, $data);

	public function downloadBody(KiiObject $object, $fp);
}

?>