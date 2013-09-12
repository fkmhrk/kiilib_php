<?php

interface UserAPI {
	const OS_ANDROID = 1;
	const OS_IOS = 2;
	public function installDevice($user, $os, $token, $development = FALSE);
}
?>