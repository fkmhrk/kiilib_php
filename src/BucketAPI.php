<?php
require_once (dirname(__FILE__). '/KiiCondition.php');
interface BucketAPI {
	public function query($bucket, $condition);
}

?>