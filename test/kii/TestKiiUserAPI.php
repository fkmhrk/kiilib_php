<?php
require_once (dirname(__FILE__) . '/../../src/kii/KiiUserAPI.php');
require_once (dirname(__FILE__) . '/../../src/KiiTopic.php');
require_once (dirname(__FILE__) . '/../mock/MockClientFactory.php');

class TestKiiUserAPI extends PHPUnit_Framework_TestCase{
	private $APP_ID = 'appId';
	private $APP_KEY = 'appKey';

	private $factory;
	private $context;

	public function __construct() {
		$this->factory = new MockClientFactory();

		$this->context = new KiiContext($this->APP_ID, $this->APP_KEY, KiiContext::SITE_US);
		$this->context->setClientFactory($this->factory);		
	}

	public function test_0000_install_Android() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);
		$deviceToken = 'token';

		// set mock
		$respBody = '{'.
			'"installationID":"2vm010uirx8c38xtpgufpie19"'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(201, $respBody));
		$installationId = $api->installDevice($user, UserAPI::OS_ANDROID, $deviceToken);
		
		// assertion
		$this->assertEquals('2vm010uirx8c38xtpgufpie19',
							$installationId);
		$sentJson = $this->factory->newClient()->sendJsonArgs[0];
		$this->assertEquals(3, count($sentJson));
		$this->assertEquals('token', $sentJson['installationRegistrationID']);
		$this->assertEquals('user1234', $sentJson['userID']);
		$this->assertEquals('ANDROID', $sentJson['deviceType']);
		$this->assertEquals('https://api.kii.com/api/apps/appId/installations',
							$this->factory->newClient()->
							urlArgs[0]);
		
	}

	public function test_0001_install_iOS_noArgs() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);
		$deviceToken = 'token';

		// set mock
		$respBody = '{'.
			'"installationID":"2vm010uirx8c38xtpgufpie19"'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(201, $respBody));
		$installationId = $api->installDevice($user, UserAPI::OS_IOS, $deviceToken);
		
		// assertion
		$this->assertEquals('2vm010uirx8c38xtpgufpie19',
							$installationId);
		$sentJson = $this->factory->newClient()->sendJsonArgs[0];
		$this->assertEquals(4, count($sentJson));
		$this->assertEquals('token', $sentJson['installationRegistrationID']);
		$this->assertEquals('user1234', $sentJson['userID']);
		$this->assertEquals('IOS', $sentJson['deviceType']);
		$this->assertEquals(FALSE, $sentJson['development']);		
		$this->assertEquals('https://api.kii.com/api/apps/appId/installations',
							$this->factory->newClient()->
							urlArgs[0]);
		
	}

	public function test_0002_install_iOS_development() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);
		$deviceToken = 'token';

		// set mock
		$respBody = '{'.
			'"installationID":"2vm010uirx8c38xtpgufpie19"'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(201, $respBody));
		$installationId = $api->installDevice($user, UserAPI::OS_IOS, $deviceToken, TRUE);
		
		// assertion
		$this->assertEquals('2vm010uirx8c38xtpgufpie19',
							$installationId);
		$sentJson = $this->factory->newClient()->sendJsonArgs[0];
		$this->assertEquals(4, count($sentJson));
		$this->assertEquals('token', $sentJson['installationRegistrationID']);
		$this->assertEquals('user1234', $sentJson['userID']);
		$this->assertEquals('IOS', $sentJson['deviceType']);
		$this->assertEquals(TRUE, $sentJson['development']);		
		$this->assertEquals('https://api.kii.com/api/apps/appId/installations',
							$this->factory->newClient()->
							urlArgs[0]);
		
	}

	public function test_0003_install_iOS_production() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);
		$deviceToken = 'token';

		// set mock
		$respBody = '{'.
			'"installationID":"2vm010uirx8c38xtpgufpie19"'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(201, $respBody));
		$installationId = $api->installDevice($user, UserAPI::OS_IOS, $deviceToken, FALSE);
		
		// assertion
		$this->assertEquals('2vm010uirx8c38xtpgufpie19',
							$installationId);
		$sentJson = $this->factory->newClient()->sendJsonArgs[0];
		$this->assertEquals(4, count($sentJson));
		$this->assertEquals('token', $sentJson['installationRegistrationID']);
		$this->assertEquals('user1234', $sentJson['userID']);
		$this->assertEquals('IOS', $sentJson['deviceType']);
		$this->assertEquals(FALSE, $sentJson['development']);		
		$this->assertEquals('https://api.kii.com/api/apps/appId/installations',
							$this->factory->newClient()->
							urlArgs[0]);
		
	}

	public function test_0100_getUser_ok() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);

		// set mock
		$respBody = '{'.
			'"userID":"deb39247-86a9-4535-9683-48a294292f67",'.
			'"internalUserID":"234279335794589696",'.
			'"loginName":"fkm",'.
			'"emailAddress":"demo@fkmsoft.jp",'.
			'"emailAddressVerified":true,'.
			'"phoneNumber":"+818011112222",'.
			'"phoneNumberVerified":true'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(200, $respBody));
		$userInfo = $api->getUser($user);
		
		// assertion
		$this->assertEquals('/users/deb39247-86a9-4535-9683-48a294292f67',
							$userInfo->getPath());
	}

	public function test_0110_getUser_cloud_exception() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);

		// set mock
		$respBody = '{'.
			'"errorCode":"USER_NOT_FOUND",'.
			'"message":"User 1234 was not found",'.
			'"value":"user1234",'.
			'"suppressed":[]'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(404, $respBody));
		try {
			$userInfo = $api->getUser($user);
			$this->assertFail('Exception must be thrown');
		} catch (CloudException $e) {
			// assertion
			$this->assertEquals(404, $e->getStatus());
		}
	}

	public function test_0200_findByUsername_ok() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		// set mock
		$respBody = '{'.
			'"userID":"deb39247-86a9-4535-9683-48a294292f67",'.
			'"internalUserID":"234279335794589696",'.
			'"loginName":"fkm",'.
			'"emailAddress":"demo@fkmsoft.jp",'.
			'"emailAddressVerified":true,'.
			'"phoneNumber":"+818011112222",'.
			'"phoneNumberVerified":true'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(200, $respBody));
		$userInfo = $api->findByUsername('name1234');
		
		// assertion
		$this->assertEquals('/users/deb39247-86a9-4535-9683-48a294292f67',
							$userInfo->getPath());
		$this->assertEquals('https://api.kii.com/api/apps/appId/users/LOGIN_NAME:name1234',
							$this->factory->newClient()->urlArgs[0]);
	}

	public function test_0210_findByUsername_cloud_exception() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		// set mock
		$respBody = '{'.
			'"errorCode":"USER_NOT_FOUND",'.
			'"message":"User 1234 was not found",'.
			'"value":"user1234",'.
			'"suppressed":[]'.
			'}';		
		$this->factory->newClient()->
			addToSend(new MockResponse(404, $respBody));
		try {
			$userInfo = $api->findByUsername('name1234');
			$this->assertFail('Exception must be thrown');
		} catch (CloudException $e) {
			// assertion
			$this->assertEquals(404, $e->getStatus());
		}
	}
	
	public function test_0300_findByEmail_ok() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		// set mock
		$respBody = '{'.
			'"userID":"deb39247-86a9-4535-9683-48a294292f67",'.
			'"internalUserID":"234279335794589696",'.
			'"loginName":"fkm",'.
			'"emailAddress":"demo@fkmsoft.jp",'.
			'"emailAddressVerified":true,'.
			'"phoneNumber":"+818011112222",'.
			'"phoneNumberVerified":true'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(200, $respBody));
		$userInfo = $api->findByEmail('email1234');
		
		// assertion
		$this->assertEquals('/users/deb39247-86a9-4535-9683-48a294292f67',
							$userInfo->getPath());
		$this->assertEquals('https://api.kii.com/api/apps/appId/users/EMAIL:email1234',
							$this->factory->newClient()->urlArgs[0]);
	}

	public function test_0310_findByEmail_cloud_exception() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		// set mock
		$respBody = '{'.
			'"errorCode":"USER_NOT_FOUND",'.
			'"message":"User 1234 was not found",'.
			'"value":"user1234",'.
			'"suppressed":[]'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(404, $respBody));
		try {
			$userInfo = $api->findByEmail('email1234');
			$this->assertFail('Exception must be thrown');
		} catch (CloudException $e) {
			// assertion
			$this->assertEquals(404, $e->getStatus());
		}
	}
	
	public function test_0400_findByPhone_ok() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		// set mock
		$respBody = '{'.
			'"userID":"deb39247-86a9-4535-9683-48a294292f67",'.
			'"internalUserID":"234279335794589696",'.
			'"loginName":"fkm",'.
			'"emailAddress":"demo@fkmsoft.jp",'.
			'"emailAddressVerified":true,'.
			'"phoneNumber":"+818011112222",'.
			'"phoneNumberVerified":true'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(200, $respBody));
		$userInfo = $api->findByPhone('phone1234');
		
		// assertion
		$this->assertEquals('/users/deb39247-86a9-4535-9683-48a294292f67',
							$userInfo->getPath());
		$this->assertEquals('https://api.kii.com/api/apps/appId/users/PHONE:phone1234',
							$this->factory->newClient()->urlArgs[0]);
	}	

	public function test_0410_findByPhone_cloud_exception() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		// set mock
		$respBody = '{'.
			'"errorCode":"USER_NOT_FOUND",'.
			'"message":"User 1234 was not found",'.
			'"value":"user1234",'.
			'"suppressed":[]'.
			'}';		
		$this->factory->newClient()->
			addToSend(new MockResponse(404, $respBody));
		try {
			$userInfo = $api->findByPhone('phone1234');
			$this->assertFail('Exception must be thrown');
		} catch (CloudException $e) {
			// assertion
			$this->assertEquals(404, $e->getStatus());			
		}
	}

	public function test_0500_subscribe_topic_ok() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);

		$topicName = 'myTopic';
		$topic = new KiiTopic($user, $topicName);
		
		// set mock
		$respBody = '';
		$this->factory->newClient()->
			addToSend(new MockResponse(204, $respBody));
		$api->subscribe($user, $topic);
		
		// assertion
		$this->assertEquals('https://api.kii.com/api/apps/appId/users/user1234/topics/myTopic/push/subscriptions/users/user1234',
							$this->factory->newClient()->urlArgs[0]);
	}

	public function test_0501_subscribe_topic_cloud_exception() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		$userId = 'user1234';
		$user = new KiiUser($userId);

		$topicName = 'myTopic';
		$topic = new KiiTopic($user, $topicName);
		
		// set mock
		$respBody = '{'.
			'"errorCode":"PUSH_SUBSCRIPTION_ALREADY_EXISTS",'.
			'"message":"Already exists a push subscription for: objectScope 1a460467/deb39247-86a9-4535-9683-48a294292f67 | topic: test | subject U:deb39247-86a9-4535-9683-48a294292f67@1a460467",'.
			'"objectScope":['.
			'{'.
            '"appID":"1a460467",'.
            '"userID":"user1234",'.
            '"type":"APP_AND_USER"'.
			'}],'.
			'"topicID":"myTopic",'.
			'"subject":"U:user1234",'.
			'"suppressed":[]'.
			'}';
		$this->factory->newClient()->
			addToSend(new MockResponse(409, $respBody));
		try {
			$api->subscribe($user, $topic);
			$this->assertFail('Exception must be thrown');			
		} catch (CloudException $e) {
			// assertion
			$this->assertEquals(409, $e->getStatus());			
		}
	}
	
	public function test_0600_uninstall_Android() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		// set mock
		$deviceToken = 'token1234';
		$respBody = '';
		
		$this->factory->newClient()->
			addToSend(new MockResponse(204, $respBody));
		$api->uninstallDevice(UserAPI::OS_ANDROID, $deviceToken);
		
		// assertion
		$this->assertEquals('https://api.kii.com/api/apps/appId/installations/ANDROID:token1234',
							$this->factory->newClient()->
							urlArgs[0]);
	}

	public function test_0601_uninstall_iOS() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		// set mock
		$deviceToken = 'token1234';
		$respBody = '';
		
		$this->factory->newClient()->
			addToSend(new MockResponse(204, $respBody));
		$api->uninstallDevice(UserAPI::OS_IOS, $deviceToken);
		
		// assertion
		$this->assertEquals('https://api.kii.com/api/apps/appId/installations/IOS:token1234',
							$this->factory->newClient()->
							urlArgs[0]);
	}

	public function test_0610_uninstall_cloud_exception() {
		$c = $this->context;
		$api = new KiiUserAPI($c);

		// set mock
		$deviceToken = 'token1234';
		$respBody = '{}'; // add later
		
		$this->factory->newClient()->
			addToSend(new MockResponse(400, $respBody));
		
		try {
			$api->uninstallDevice(UserAPI::OS_ANDROID, $deviceToken);
			$this->assertFail('Exception must be thrown');			
		} catch (CloudException $e) {
			// assertion
			$this->assertEquals(400, $e->getStatus());
		}
	}	
}
?>