<?php
require_once (dirname(__FILE__). '/../../src/HttpClientFactory.php');
require_once (dirname(__FILE__). '/MockHttpClient.php');
require_once (dirname(__FILE__). '/MockResponse.php');
							  
class MockClientFactory implements HttpClientFactory {
	private $client;

	public function __construct()
    {
		$this->client = new MockHttpClient();
	}
	
	public function newClient() : HttpClient
    {
		return $this->client;
	}
}
?>