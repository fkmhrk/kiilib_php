<?php
require_once (dirname(__FILE__) . '/KiiUser.php');
interface GroupAPI {
	public function getJoinedGroups(KiiUser $user);
}
?>