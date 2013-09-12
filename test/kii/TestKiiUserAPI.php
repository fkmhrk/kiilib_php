<?php
require_once (dirname(__FILE__) . '/../../src/kii/KiiUserAPI.php');
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
}
?>