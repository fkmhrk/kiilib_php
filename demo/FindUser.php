<?php
require_once (dirname(__FILE__). '/Constants.php');
require_once (dirname(__FILE__). '/../src/kii/KiiAppAPI.php');

$context = new KiiContext(APP_ID, APP_KEY, SITE);
$api = new KiiAppAPI($context);
$userApi = $api->userAPI();

try {
	$user = $api->login('fkm', '123456');
	echo 'user id : ' . $user->getPath(). "\n";
	
	$user2 = $userApi->findByUsername('fkm2');
	// $user2 = $userApi->findByEmail('demo@fkmsoft.jp');
	// $user2 = $userApi->findByPhone('+819011112222');	
	echo 'username : ' . $user2->data['loginName']. "\n";	
} catch (CloudException $e) {
	echo 'failed to login '. $e->getStatus();
	print_r($e->getResponse());
}
?>