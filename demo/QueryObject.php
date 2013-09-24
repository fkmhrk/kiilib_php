<?php
require_once (dirname(__FILE__). '/Constants.php');
require_once (dirname(__FILE__). '/../src/kii/KiiAppAPI.php');

$context = new KiiContext(APP_ID, APP_KEY, SITE);
// create APIs
$appApi = new KiiAppAPI($context);
$api = $appApi->bucketAPI();

try {
	$user = $appApi->login('fkm', '123456');

	$bucket = new KiiBucket($user, 'post');
	$condition = new KiiCondition(KiiClause::all());
	$condition->setLimit(1);

	do {
		echo "query object\n";
		
		$result = $api->query($bucket, $condition);
		print_r($result);

	} while ($condition->hasNext());

} catch (CloudException $e) {
	echo 'failed to call Kii API '. $e->getStatus();
	print_r($e->getResponse());
}
?>