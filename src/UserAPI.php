<?php

interface UserAPI {
	const OS_ANDROID = 1;
	const OS_IOS = 2;

	public function getUser($user);
	
	public function findByUsername($username);

	public function findByEmail($email);

	public function findByPhone($phone);
	
	public function installDevice($user, $os, $token, $development = FALSE);

	public function subscribe($user, $target);
}
?>