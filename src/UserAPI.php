<?php
require_once (dirname(__FILE__) . '/KiiUser.php');
interface UserAPI {
	const OS_ANDROID = 1;
	const OS_IOS = 2;

	public function getUser(KiiUser $user);
	
	public function findByUsername(string $username);

	public function findByEmail(string $email);

	public function findByPhone(string $phone);
	
	public function installDevice(KiiUser $user, int $os, string $token, bool $development = FALSE);

	public function uninstallDevice(int $os, string $token);

	public function subscribe(KiiUser $user, $target);
}
?>