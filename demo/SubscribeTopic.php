<?php
require_once (dirname(__FILE__). '/Constants.php');
require_once (dirname(__FILE__). '/../src/kii/KiiAppAPI.php');

$context = new KiiContext(APP_ID, APP_KEY, SITE);
// create APIs
$appApi = new KiiAppAPI($context);
$userApi = $appApi->userAPI();

// If topic is already subscribed, API throws CloudException with HTTP 409
try {
	$user = $appApi->login('fkm', '123456');

	$topic = new KiiTopic($user, 'test');

	$userApi->subscribe($user, $topic);
	echo 'topic[test] is subscribed';
	
} catch (CloudException $e) {
	echo 'failed to call Kii API '. $e->getStatus();
	print_r($e->getResponse());
}
?>