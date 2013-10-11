<?php
require_once (dirname(__FILE__) . '/KiiUser.php');
interface UserAPI {
	const OS_ANDROID = 1;
	const OS_IOS = 2;

	public function getUser(KiiUser $user);
	
	public function findByUsername($username);

	public function findByEmail($email);

	public function findByPhone($phone);
	
	public function installDevice(KiiUser $user, $os, $token, $development = FALSE);

	public function uninstallDevice($os, $token);

	public function subscribe(KiiUser $user, $target);
}
?>