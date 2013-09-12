<?php
require_once (dirname(__FILE__). '/Constants.php');
require_once (dirname(__FILE__). '/../src/kii/KiiAppAPI.php');

$context = new KiiContext(APP_ID, APP_KEY, SITE);
// create APIs
$appApi = new KiiAppAPI($context);
$groupApi = $appApi->groupAPI();
$topicApi = $appApi->topicAPI();

// assumption
// - This user joins more than 1 group
// - The first group has the topic whose name is 'test'
// - This user subscribes the 'test' topic
try {
	$user = $appApi->login('fkm', '123456');
	$groupList = $groupApi->getJoinedGroups($user);
	print_r($groupList);
	$group = $groupList[0];

	$topic = new KiiTopic($group, 'test');
	$message = new KiiTopicMessage();
	$message->data['msg'] = 'hello';

	$result = $topicApi->sendMessage($topic, $message);
	echo 'push id : '. $result;
	
} catch (CloudException $e) {
	echo 'failed to call Kii API '. $e->getStatus();
	print_r($e->getResponse());
}
?>