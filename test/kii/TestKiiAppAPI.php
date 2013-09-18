<?php
require_once (dirname(__FILE__) . '/../../src/kii/KiiAppAPI.php');
require_once (dirname(__FILE__) . '/../mock/MockClientFactory.php');

class TestKiiAppAPI extends PHPUnit_Framework_TestCase{
	private $APP_ID = 'appId';
	private $APP_KEY = 'appKey';

	private $factory;
	private $context;

	public function __construct() {
		$this->factory = new MockClientFactory();

		$this->context = new KiiContext($this->APP_ID, $this->APP_KEY, KiiContext::SITE_US);
		$this->context->setClientFactory($this->factory);		
	}
	
	public function test_0000_login_ok() {
		$api = new KiiAppAPI($this->context);
		
		// set mock
		$respBody = '{"id":"ff43674e-b62c-4933-86cc-fd47bb89b398",'.
			'"access_token":"a8d808e6-495d-4968-9c54-27979369c9c8",'.
			'"expires_in":9223372036854775}';
		$this->factory->newClient()->
			addToSend(new MockResponse(200, $respBody));

		// call API
		$user = $api->login('user1234', '123456');
		
		// assertion
		$this->assertEquals("/users/ff43674e-b62c-4933-86cc-fd47bb89b398",
							$user->getPath());
		$this->assertEquals("a8d808e6-495d-4968-9c54-27979369c9c8",
							$this->context->getAccessToken());
		$sentJson = $this->factory->newClient()->sendJsonArgs[0];
		$this->assertEquals(2, count($sentJson));
		$this->assertEquals('user1234', $sentJson['username']);
		$this->assertEquals('123456', $sentJson['password']);		
	}

	public function test_0010_login_cloud_exception() {
		$api = new KiiAppAPI($this->context);
		
		// set mock
		$respBody = '{"errorCode":"invalid_grant","'.
			'"error_description":"The user was not found or a wrong password was provided",'.
			'"error":"invalid_grant"}';
		$this->factory->newClient()->
			addToSend(new MockResponse(400, $respBody));

		// call API
		try {
			$user = $api->login('user1234', '123456');
			$this->assertFail('exception must be thrown');
		} catch (CloudException $e) {
			$this->assertEquals(400, $e->getStatus());
		}
	}

	public function test_0100_loginAsAdmin_ok() {
		$api = new KiiAppAPI($this->context);
		
		// set mock
		$respBody = '{"id":"ff43674e-b62c-4933-86cc-fd47bb89b398",'.
			'"access_token":"a8d808e6-495d-4968-9c54-27979369c9c8",'.
			'"expires_in":9223372036854775}';
		$this->factory->newClient()->
			addToSend(new MockResponse(200, $respBody));

		// call API
		$user = $api->loginAsAdmin('ID', 'Secret');
		
		// assertion
		$this->assertEquals("/users/ff43674e-b62c-4933-86cc-fd47bb89b398",
							$user->getPath());
		$this->assertEquals("a8d808e6-495d-4968-9c54-27979369c9c8",
							$this->context->getAccessToken());
		$sentJson = $this->factory->newClient()->sendJsonArgs[0];
		$this->assertEquals(2, count($sentJson));
		$this->assertEquals('ID', $sentJson['client_id']);
		$this->assertEquals('Secret', $sentJson['client_secret']);
	}

	public function test_0110_loginAsAdmin_cloud_exception() {
		$api = new KiiAppAPI($this->context);
		
		// set mock
		$respBody = '{"errorCode":"invalid_grant","'.
			'"error_description":"The user was not found or a wrong password was provided",'.
			'"error":"invalid_grant"}';
		$this->factory->newClient()->
			addToSend(new MockResponse(400, $respBody));

		// call API
		try {
			$user = $api->loginAsAdmin('ID', 'Secret');
			$this->assertFail('exception must be thrown');
		} catch (CloudException $e) {
			$this->assertEquals(400, $e->getStatus());
		}
	}	
}
?>