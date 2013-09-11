<?php
interface AppAPI {
	public function login($userIdentifier, $password);
	// APIs
	public function userAPI();
	public function bucketAPI();
	public function objectAPI();
	public function aclAPI();
}
?>