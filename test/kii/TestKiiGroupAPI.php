<?php
require_once (dirname(__FILE__) . '/../../src/kii/KiiGroupAPI.php');
require_once (dirname(__FILE__) . '/../mock/MockClientFactory.php');

class TestKiiGroupAPI extends PHPUnit_Framework_TestCase{
	private $APP_ID = 'appId';
	private $APP_KEY = 'appKey';

	private $factory;
	private $context;

	public function __construct() {
		$this->factory = new MockClientFactory();

		$this->context = new KiiContext($this->APP_ID, $this->APP_KEY, KiiContext::SITE_US);
		$this->context->setClientFactory($this->factory);		
	}

	public function test_0000_joinedMember_ok() {
		$c = $this->context;
		$api = new KiiGroupAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);

		// set mock
		$respBody = '{"groups":['.
			'{'.
			'"groupID":"2d7c1743-0a90-4b91-8d82-c7800951ae4c",'.
			'"name":"testing group 1",'.
			'"owner":"0f418324-6c94-4db1-a683-dd7d802f1e92"'.
			'},'.
			'{'. 
			'"groupID":"9367d8bc-0ca0-4495-8cca-c1637715b917",'. 
			'"name":"testing group 2",'.
			'"owner":"0f418324-6c94-4db1-a683-dd7d802f1e92"'.
			'}]'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(200, null, $respBody));
		$result = $api->getJoinedGroups($user);
		// assertion
		$this->assertEquals(2, count($result));
		$group = $result[0];
		$this->assertEquals('/groups/2d7c1743-0a90-4b91-8d82-c7800951ae4c',
							$group->getPath());
		$group = $result[1];
		$this->assertEquals('/groups/9367d8bc-0ca0-4495-8cca-c1637715b917',
							$group->getPath());
	}

	public function test_0010_joinedMember_cloud_exception() {
		$c = $this->context;
		$api = new KiiGroupAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);

		// set mock
		$respBody = '{'.
			'"errorCode":"USER_NOT_FOUND",'.
			'"message":"User user1234 was not found",'.
			'"value":"user1234",'.
			'"suppressed":[ ]}';
		$this->factory->newClient()->
			addToSend(new MockResponse(404, null, $respBody));
		try {
			$result = $api->getJoinedGroups($user);
			$this->assertFail('exception must be thrown');
		} catch (CloudException $e) {
			$this->assertEquals(404, $e->getStatus());
		}
	}	
}
?>