<?php
require_once (dirname(__FILE__) . '/KiiTopic.php');
require_once (dirname(__FILE__) . '/KiiTopicMessage.php');

interface TopicAPI {
	public function create(KiiTopic $topic);
	
	public function sendMessage(KiiTopic $topic, KiiTopicMessage $message);
}

?>