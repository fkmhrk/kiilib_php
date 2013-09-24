<?php
require_once (dirname(__FILE__) . '/../../src/KiiUser.php');
require_once (dirname(__FILE__) . '/../../src/kii/KiiBucketAPI.php');
require_once (dirname(__FILE__) . '/../mock/MockClientFactory.php');

class TestKiiBucketAPI extends PHPUnit_Framework_TestCase{
	private $APP_ID = 'appId';
	private $APP_KEY = 'appKey';

	private $factory;
	private $context;

	public function __construct() {
		$this->factory = new MockClientFactory();

		$this->context = new KiiContext($this->APP_ID, $this->APP_KEY, KiiContext::SITE_US);
		$this->context->setClientFactory($this->factory);		
	}

	public function test_0000_query_ok() {
		$c = $this->context;
		$api = new KiiBucketAPI($c);

		$userId = 'user1234';
		$bucket = new KiiBucket(new KiiUser($userId), 'test');

		$condition = new KiiCondition(KiiClause::all());

		// set mock
		$respBody = '{'.
			'"queryDescription":"WHERE ( ( name = \'John Doe\' ) OR ( age = 30 ) )",'.
			'"results":['.
			'{"_id":"72d4f64d-01ab-4722-9330-70e33ae2bfbb","name":"John Doe","age":30,'.
			'"_created":1334505473494,"_modified":1334505473494,"_owner":"789399f7-7552-47a8-a524-b9119056edd9"},'.
			'{"_id":"af2a9367-01cd-4edc-af6d-40c9607e4410","name":"John Doe","age":45,'.
			'"_created":1334505481261,"_modified":1334505481261,"_owner":"789399f7-7552-47a8-a524-b9119056edd9"}'.
			']'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(200, $respBody));		
		$result = $api->query($bucket, $condition);

		// assertion
		$this->assertEquals(2, count($result));
		$obj0 = $result[0];
		$this->assertEquals('/users/user1234/buckets/test/objects/72d4f64d-01ab-4722-9330-70e33ae2bfbb', $obj0->getPath());
		$obj1 = $result[1];
		$this->assertEquals('/users/user1234/buckets/test/objects/af2a9367-01cd-4edc-af6d-40c9607e4410', $obj1->getPath());

		$this->assertFalse($condition->hasNext());
	}

	public function test_0001_query_hasNext() {
		$c = $this->context;
		$api = new KiiBucketAPI($c);

		$userId = 'user1234';
		$bucket = new KiiBucket(new KiiUser($userId), 'test');

		$condition = new KiiCondition(KiiClause::all());

		// set mock
		$respBody = '{'.
			'"queryDescription":"WHERE ( ( name = \'John Doe\' ) OR ( age = 30 ) )",'.
			'"nextPaginationKey":"200/2",'.
			'"results":['.
			'{"_id":"72d4f64d-01ab-4722-9330-70e33ae2bfbb","name":"John Doe","age":30,'.
			'"_created":1334505473494,"_modified":1334505473494,"_owner":"789399f7-7552-47a8-a524-b9119056edd9"}'.
			']'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(200, $respBody));		
		$result = $api->query($bucket, $condition);

		// assertion
		$this->assertEquals(1, count($result));
		$obj0 = $result[0];
		$this->assertEquals('/users/user1234/buckets/test/objects/72d4f64d-01ab-4722-9330-70e33ae2bfbb', $obj0->getPath());

		$this->assertTrue($condition->hasNext());
	}

	public function test_0010_query_cloud_exception() {
		$c = $this->context;
		$api = new KiiBucketAPI($c);

		$userId = 'user1234';
		$bucket = new KiiBucket(new KiiUser($userId), 'test');

		$condition = new KiiCondition(KiiClause::all());

		// set mock
		$respBody = '{'.
			'"errorCode":"USER_NOT_FOUND",'.
			'"message":"User user1234 was not found",'.
			'"value":"user1234",'.
			'"suppressed":[]'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(404, $respBody));
		try {
			$api->query($bucket, $condition);
			$this->assertFail('Exception must be thrown');
		} catch (CloudException $e) {
			$this->assertEquals(404, $e->getStatus());
		}
	}	
}

?>
