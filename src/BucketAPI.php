<?php
require_once (dirname(__FILE__). '/KiiBucket.php');
require_once (dirname(__FILE__). '/KiiCondition.php');
interface BucketAPI {
	public function query(KiiBucket $bucket, KiiCondition $condition);

	public function delete(KiiBucket $bucket);
}

?>