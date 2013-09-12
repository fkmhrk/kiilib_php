<?php
interface AppAPI {
	public function login($userIdentifier, $password);
	// APIs
	public function userAPI();
	public function groupAPI();
	public function bucketAPI();
	public function objectAPI();
	public function aclAPI();
	public function topicAPI();
}
?>