<?php
require_once (dirname(__FILE__). '/Constants.php');
require_once (dirname(__FILE__). '/../src/kii/KiiAppAPI.php');

$context = new KiiContext(APP_ID, APP_KEY, SITE);
// create APIs
$appApi = new KiiAppAPI($context);
$api = $appApi->objectAPI();

$fp = null;
try {
	$user = $appApi->login('fkm', '123456');
	$bucket = new KiiBucket($user, 'image');
	$data = array(
				  'name' => 'image.jpg'
				  );
	$obj = $api->create($bucket, $data);

	// upload file
	$fp = fopen(dirname(__FILE__). '/image.jpg', 'r');
	$updated = $api->updateBody($obj, 'image/jpeg', $fp);

	echo "Let's get the file by the following curl command\n";
	echo "curl -v -X GET -H 'authorization:bearer ".
		$context->getAccessToken().
		"' -H 'x-kii-appid:". APP_ID.
		"' -H 'x-kii-appkey:". APP_KEY.
		"' '". SITE.
		"/apps/". APP_ID.
		$updated->getPath().
		"/body' > out.jpg";
	
} catch (CloudException $e) {
	echo 'failed to call Kii API '. $e->getStatus();
	print_r($e->getResponse());
}

if ($fp != null) {
	fclose($fp);
}
?>