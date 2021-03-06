<?php
require_once (dirname(__FILE__). '/Constants.php');
require_once (dirname(__FILE__). '/../src/kii/KiiAppAPI.php');

$context = new KiiContext(APP_ID, APP_KEY, SITE);
// create APIs
$appApi = new KiiAppAPI($context);
$api = $appApi->objectAPI();

try {
	$user = $appApi->login('fkm', '123456');

	$bucket = new KiiBucket($user, 'post');
	$data = array(
				  'name' => 'fkm'
				  );
	$obj = $api->create($bucket, $data);
	print_r($obj);
	// update field
	$obj->data['score'] = 120;
	$updated = $api->update($obj);
	print_r($updated);

    // update patch
    $patch = array(
                   'level' => 'easy'
                   );
    $updated = $api->updatePatch($obj, $patch);
	print_r($updated);

	// update IfUnmodified
	echo "Update If object is unmodified on the cloud\n";
	$updated->data['score'] = 200;
	$updated = $api->updateIfUnmodified($updated);
	print_r($updated);

	// if version is not matched, API call will be failed.
	$updated->data['score'] = 300;
	$updated->version = "1"; // old version
	try {
		$updated = $api->updateIfUnmodified($updated);
		echo "Updated????\n";
	} catch (CloudException $e) {
		print_r($e);
	}

	
} catch (CloudException $e) {
	echo 'failed to call Kii API '. $e->getStatus();
	print_r($e->getResponse());
}
?>