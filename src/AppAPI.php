<?php
interface AppAPI {
	public function login(string $userIdentifier, string $password);
	public function loginAsAdmin(string $clientId, string $clientSecret);
	// APIs
	public function userAPI() : UserAPI;
	public function groupAPI() : GroupAPI;
	public function bucketAPI() : BucketAPI ;
	public function objectAPI() : ObjectAPI;
	public function aclAPI() : ACLAPI;
	public function topicAPI() : TopicAPI;
}
?>