<?php
require_once (dirname(__FILE__). '/Constants.php');
require_once (dirname(__FILE__). '/../src/kii/KiiAppAPI.php');

$context = new KiiContext(APP_ID, APP_KEY, SITE);
// create APIs
$appApi = new KiiAppAPI($context);
$api = $appApi->groupAPI();

try {
	$user = $appApi->login('fkm', '123456');
	$groupList = $api->getJoinedGroups($user);
	print_r($groupList);
} catch (CloudException $e) {
	echo 'failed to call Kii API '. $e->getStatus();
	print_r($e->getResponse());
}
?>