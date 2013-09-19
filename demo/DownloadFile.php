<?php
require_once (dirname(__FILE__). '/Constants.php');
require_once (dirname(__FILE__). '/../src/kii/KiiAppAPI.php');

$context = new KiiContext(APP_ID, APP_KEY, SITE);
// create APIs
$appApi = new KiiAppAPI($context);
$api = $appApi->objectAPI();

$fp = null;
$fp2 = null;
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

	echo "Upload is done!\n";
	
	// download file
	$fp2 = fopen(dirname(__FILE__). '/downloadImage.jpg', 'wb');
	$api->downloadBody($obj, $fp2);
	echo "Download is done! Please see downloadImage.jpg\n";
	
} catch (CloudException $e) {
	echo 'failed to call Kii API '. $e->getStatus();
	print_r($e->getResponse());
}

if ($fp != null) {
	fclose($fp);
}
if ($fp2 != null) {
	fclose($fp2);
}
?>