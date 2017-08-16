<?php
require_once (dirname(__FILE__) . '/../UserAPI.php');
require_once (dirname(__FILE__) . '/../KiiContext.php');
require_once (dirname(__FILE__) . '/../CloudException.php');

class KiiUserAPI implements UserAPI {
	private $context;

	public function __construct(KiiContext $context)
    {
		$this->context = $context;
	}
	
	public function getUser(KiiUser $user)
    {
		$c = $this->context;
		$url = $c->getServerUrl().
			'/apps/'. $c->getAppId().
			$user->getPath();
		return $this->execGet($url);
	}

	public function findByUsername(string $username)
    {
		$c = $this->context;
		$url = $c->getServerUrl().
			'/apps/'. $c->getAppId().
			'/users/LOGIN_NAME:'. $username;
		return $this->execGet($url);
	}

	public function findByEmail(string $email)
    {
		$c = $this->context;
		$url = $c->getServerUrl().
			'/apps/'. $c->getAppId().
			'/users/EMAIL:'. $email;
		return $this->execGet($url);
	}

	public function findByPhone(string $phone)
    {
		$c = $this->context;
		$url = $c->getServerUrl().
			'/apps/'. $c->getAppId().
			'/users/PHONE:'. $phone;
		return $this->execGet($url);
	}

	private function execGet(string $url) {
		$c = $this->context;
		
		$client = $c->getNewClient();
		$client->setUrl($url);
		$client->setMethod(HttpClient::HTTP_GET);
		$client->setKiiHeader($c, TRUE);

		$resp = $client->send();
		if ($resp->getStatus() != 200) {
			throw new CloudException($resp->getStatus(), $resp->getAsJson());
		}
		$respJson = $resp->getAsJson();
		$userId = $respJson['userID'];

		$info = new KiiUser($userId);
		$info->data = $respJson;

		return $info;		
	}
	
	public function installDevice(KiiUser $user, int $os, string $token, bool $development = FALSE)
    {
		$c = $this->context;
		$url = $c->getServerUrl().
			'/apps/'. $c->getAppId().
			'/installations';
		$data = array(
					  "installationRegistrationID" => $token,
					  "userID" => $user->getId(),
					  "deviceType" => $this->toDeviceType($os)
					  );
		if ($os == UserAPI::OS_IOS) {
			$data['development'] = $development;
		}

		$client = $c->getNewClient();
		$client->setUrl($url);
		$client->setMethod(HttpClient::HTTP_POST);
		$client->setKiiHeader($c, TRUE);
		$client->setContentType('application/vnd.kii.InstallationCreationRequest+json');

		$resp = $client->sendJson($data);
		if ($resp->getStatus() != 201) {
			throw new CloudException($resp->getStatus(), $resp->getAsJson());
		}
		$respJson = $resp->getAsJson();
		return $respJson['installationID'];
	}

	public function uninstallDevice(int $os, string $token)
    {
		$c = $this->context;
		$url = $c->getServerUrl().
			'/apps/'. $c->getAppId().
			'/installations/'. $this->toDeviceType($os).
			':'. $token;

		$client = $c->getNewClient();
		$client->setUrl($url);
		$client->setMethod(HttpClient::HTTP_DELETE);
		$client->setKiiHeader($c, TRUE);

		$resp = $client->send();
		if ($resp->getStatus() != 204) {
			throw new CloudException($resp->getStatus(), $resp->getAsJson());
		}
	}
	
	private function toDeviceType(int $os) : string
    {
		switch ($os) {
		case UserAPI::OS_ANDROID: return 'ANDROID';
		case UserAPI::OS_IOS: return 'IOS';
		default: return '';
		}
	}

	public function subscribe(KiiUser $user, $target)
    {
		$c = $this->context;
		$url = $c->getServerUrl().
			'/apps/'. $c->getAppId().
			$target->getPath().
			'/push/subscriptions'.
			$user->getPath();

		$client = $c->getNewClient();
		$client->setUrl($url);
		$client->setMethod(HttpClient::HTTP_PUT);
		$client->setKiiHeader($c, TRUE);

		$resp = $client->send();
		if ($resp->getStatus() != 204) {
			throw new CloudException($resp->getStatus(), $resp->getAsJson());
		}
	}
}
?>