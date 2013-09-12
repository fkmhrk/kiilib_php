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

	public function __construct($appId, $appKey, $serverUrl) {
		$this->appId = $appId;
		$this->appKey = $appKey;
		$this->serverUrl = $serverUrl;
		$this->clientFactory = new KiiHttpClientFactory();
	}

	public function getAppId() {
		return $this->appId;
	}

	public function getAppKey() {
		return $this->appKey;
	}

	public function getServerUrl() {
		return $this->serverUrl;
	}

	public function setAccessToken($token) {
		$this->token = $token;
	}

	public function getAccessToken() {
		return $this->token;
	}

	public function setClientFactory($factory) {
		$this->clientFactory = $factory;
	}

	public function getNewClient() {
		return $this->clientFactory->newClient();
	}
}
?>