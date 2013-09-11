<?php
class KiiContext {
	const SITE_US = "https://api.kii.com/api";
	const SITE_JP = "https://api-jp.kii.com/api";
	const SITE_CN = "https://api-cn2.kii.com/api";

	private $appId;
	private $appKey;
	private $serverUrl;
	private $token;

	public function __construct($appId, $appKey, $serverUrl) {
		$this->appId = $appId;
		$this->appKey = $appKey;
		$this->serverUrl = $serverUrl;
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
}
?>