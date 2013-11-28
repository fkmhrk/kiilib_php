<?php
require_once (dirname(__FILE__) . '/../../src/KiiUser.php');
require_once (dirname(__FILE__) . '/../../src/kii/KiiObjectAPI.php');
require_once (dirname(__FILE__) . '/../mock/MockClientFactory.php');

class TestKiiObjectAPI extends PHPUnit_Framework_TestCase{
	private $APP_ID = 'appId';
	private $APP_KEY = 'appKey';

	private $factory;
	private $context;

	public function __construct() {
		$this->factory = new MockClientFactory();

		$this->context = new KiiContext($this->APP_ID, $this->APP_KEY, KiiContext::SITE_US);
		$this->context->setClientFactory($this->factory);		
	}

	public function test_0000_create_ok() {
		$c = $this->context;
		$api = new KiiObjectAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);
		$bucket = new KiiBucket($user, 'test');

		$data = array(
					  "name" => "fkm",
					  "score" => 120
					  );

		// set mock
		$respBody = '{'.
			'"objectID":"d8dc9f29-0fb9-48be-a80c-ec60fddedb54",'.
			'"createdAt":1337039114613,'.
			'"dataType":"application/vnd.sandobx.mydata+json"'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(201, array('etag' => "1"), $respBody));		
		$obj = $api->create($bucket, $data);
		
		// assertion
		$this->assertEquals('d8dc9f29-0fb9-48be-a80c-ec60fddedb54',
							$obj->getId());
		$this->assertEquals("1", $obj->version);
		$json = $obj->data;
		$this->assertEquals(2, count($json));
		$this->assertEquals('fkm', $json['name']);
		$this->assertEquals(120, $json['score']);
	}

	public function test_0100_update_ok() {
		$c = $this->context;
		$api = new KiiObjectAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);
		$bucket = new KiiBucket($user, 'test');

		$objectId = 'obj1234';
		$data = array(
					  "name" => "fkm",
					  "score" => 120
					  );		
		$object = new KiiObject($bucket, $objectId, $data);
		// update field
		$object->data['score'] = 255;
		
		// set mock
		$respBody = '{'. 
			'"modifiedAt":1337039448517'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(200, array('etag' => '2'), $respBody));
		$updated = $api->update($object);
		
		// assertion
		$this->assertEquals('obj1234',
							$updated->getId());
		$this->assertEquals("2", $updated->version);		
		$json = $updated->data;
		$this->assertEquals(2, count($json));
		$this->assertEquals('fkm', $json['name']);
		$this->assertEquals(255, $json['score']);
	}

	public function test_0200_updateIfUnmodified_ok() {
		$c = $this->context;
		$api = new KiiObjectAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);
		$bucket = new KiiBucket($user, 'test');

		$objectId = 'obj1234';
		$data = array(
					  "name" => "fkm",
					  "score" => 120
					  );		
		$object = new KiiObject($bucket, $objectId, $data);
		// update field
		$object->data['score'] = 255;
		
		// set mock
		$respBody = '{'. 
			'"modifiedAt":1337039448517'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(200, array('etag' => '2'), $respBody));
		$updated = $api->updateIfUnmodified($object);
		
		// assertion
		$this->assertEquals('obj1234',
							$updated->getId());
		$this->assertEquals("2", $updated->version);		
		$json = $updated->data;
		$this->assertEquals(2, count($json));
		$this->assertEquals('fkm', $json['name']);
		$this->assertEquals(255, $json['score']);
	}	

	public function test_0200_delete_ok() {
		$c = $this->context;
		$api = new KiiObjectAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);
		$bucket = new KiiBucket($user, 'test');

		$objectId = 'obj1234';
		$data = array();
		$object = new KiiObject($bucket, $objectId, $data);
		
		// set mock
		$respBody = '';
		$this->factory->newClient()->
			addToSend(new MockResponse(204, null, $respBody));
		$api->delete($object);
		
		// assertion
		$this->assertEquals('https://api.kii.com/api/apps/appId/users/user1234/buckets/test/objects/obj1234',
							$this->factory->newClient()->
							urlArgs[0]);
	}
	
	public function test_0210_delete_cloud_exception() {
		$c = $this->context;
		$api = new KiiObjectAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);
		$bucket = new KiiBucket($user, 'test');

		$objectId = 'obj1234';
		$data = array();
		$object = new KiiObject($bucket, $objectId, $data);
		
		// set mock
		$respBody = '{'.
			'"errorCode":"OBJECT_NOT_FOUND",'.
			'"message":"The object with ID obj1234 was not found in bucket post(scope = appId/user1234)",'.
			'"objectScope":{'.
			'"appID":"appId",'.
			'"userID":"user1234",'.
			'"type":"APP_AND_USER"'.
			'},'.
			'"bucketID":"post",'.
			'"objectID":"obj1234",'.
			'"suppressed": [ ]'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(404, null, $respBody));
		try {
			$api->delete($object);
			$this->assertFail('exception must be thrown');
		} catch (CloudException $e) {
			$this->assertEquals(404, $e->getStatus());
		}
	}

	public function test_0300_updateBody_ok() {
		$c = $this->context;
		$api = new KiiObjectAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);
		$bucket = new KiiBucket($user, 'test');

		$objectId = 'obj1234';
		$data = array(
					  "name" => "fkm",
					  "score" => 120
					  );		
		$object = new KiiObject($bucket, $objectId, $data);
		// upload body
		$fp = fopen('php://memory', 'rw');
		fwrite($fp, 'test');
		rewind($fp);
		
		// set mock
		$respBody = ''; 
		$this->factory->newClient()->
			addToSend(new MockResponse(200, null, $respBody));
		$updated = $api->updateBody($object, 'text/plain', $fp);
		fclose($fp);
		
		// assertion
		$this->assertEquals('obj1234',
							$updated->getId());
		$json = $updated->data;
		$this->assertEquals(2, count($json));
		$this->assertEquals('fkm', $json['name']);
		$this->assertEquals(120, $json['score']);
	}

	public function test_0400_downloadBody_ok() {
		$c = $this->context;
		$api = new KiiObjectAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);
		$bucket = new KiiBucket($user, 'test');

		$objectId = 'obj1234';
		$data = array(
					  "name" => "fkm",
					  "score" => 120
					  );		
		$object = new KiiObject($bucket, $objectId, $data);
		// download body
		$fp = fopen('php://memory', 'rw');
		
		// set mock
		$respFile = 'abcde'; 
		$this->factory->newClient()->
			addToSendForDownload($respFile);
		$respBody = ''; 
		$this->factory->newClient()->
			addToSend(new MockResponse(200, null, $respBody));	
		$api->downloadBody($object, $fp);
		rewind($fp);
		$data = stream_get_contents($fp);
		fclose($fp);
		
		// assertion
		$this->assertEquals('abcde', $data);
	}	
}
?>