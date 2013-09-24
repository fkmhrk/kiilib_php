<?php
interface TopicAPI {
	public function create($topic);
	
	public function sendMessage($topic, $message);
}

?>