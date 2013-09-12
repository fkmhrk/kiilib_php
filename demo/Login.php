<?php
require_once (dirname(__FILE__). '/Constants.php');
require_once (dirname(__FILE__). '/../src/kii/KiiAppAPI.php');

$context = new KiiContext(APP_ID, APP_KEY, SITE);
$api = new KiiAppAPI($context);

try {
	$user = $api->login('fkm', '123456');
	echo 'user id : ' . $user->getPath(). "\n";
} catch (CloudException $e) {
	echo 'failed to login '. $e->getStatus();
	print_r($e->getResponse());
}
?>