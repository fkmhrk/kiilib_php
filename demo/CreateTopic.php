<?php
require_once (dirname(__FILE__). '/Constants.php');
require_once (dirname(__FILE__). '/../src/kii/KiiAppAPI.php');

$context = new KiiContext(APP_ID, APP_KEY, SITE);
// create APIs
$appApi = new KiiAppAPI($context);
$groupApi = $appApi->groupAPI();
$topicApi = $appApi->topicAPI();

// If topic is already created, API throws CloudException with HTTP 409
try {
	$user = $appApi->login('fkm', '123456');

	$topic = new KiiTopic($user, 'test');

	$topicApi->create($topic);
	echo 'topic[test] is created';
	
} catch (CloudException $e) {
	echo 'failed to call Kii API '. $e->getStatus();
	print_r($e->getResponse());
}
?>