<?php
require_once (dirname(__FILE__). '/kii/private/KiiHttpClientFactory.php');

class KiiContext {
	const SITE_US = "https://api.kii.com/api";
	const SITE_JP = "https://api-jp.kii.com/api";
	const SITE_CN = "https://api-cn2.kii.com/api";

	private $appId;
	private $appKey;
	private $serverUrl;
	private $token;

	private $clientFactory;

	public function __construct(string $appId, string $appKey, string $serverUrl)
    {
		$this->appId = $appId;
		$this->appKey = $appKey;
		$this->serverUrl = $serverUrl;
		$this->clientFactory = new KiiHttpClientFactory();
	}

	public function getAppId() : string
    {
		return $this->appId;
	}

	public function getAppKey() : string
    {
		return $this->appKey;
	}

	public function getServerUrl() : string
    {
		return $this->serverUrl;
	}

	public function setAccessToken(string $token)
    {
		$this->token = $token;
	}

	public function getAccessToken() : string
    {
		return $this->token;
	}

	public function setClientFactory(HttpClientFactory $factory)
    {
		$this->clientFactory = $factory;
	}

	public function getNewClient() : HttpClient
    {
		return $this->clientFactory->newClient();
	}
}
?>