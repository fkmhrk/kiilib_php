<?php
interface AppAPI {
	public function login($userIdentifier, $password);
	public function loginAsAdmin($clientId, $clientSecret);
	// APIs
	public function userAPI();
	public function groupAPI();
	public function bucketAPI();
	public function objectAPI();
	public function aclAPI();
	public function topicAPI();
}
?>