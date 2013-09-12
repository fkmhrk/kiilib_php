<?php
require_once (dirname(__FILE__). '/KiiGCMMessage.php');
require_once (dirname(__FILE__). '/KiiAPNsMessage.php');

class KiiTopicMessage {
	public $data;
	private $sendToDevelopment;
	private $sendToProduction;
	private $pushMessageType;
	private $sendAppID;
	private $sendSender;
	private $sendWhen;
	private $sendOrigin;
	private $sendObjectScope;
	private $sendTopicID;
	public $gcm;
	public $apns;	

	public function __construct() {
		$this->data = array();
		$this->sendToDevelopment = TRUE;
		$this->sendToProduction = TRUE;
		$this->pushMessageType = '';
		$this->sendAppID = FALSE;
		$this->sendSender = TRUE;
		$this->sendWhen = FALSE;
		$this->sendOrigin = FALSE;
		$this->sendObjectScope = TRUE;
		$this->sendTopicID = TRUE;
		
		$this->gcm = new KiiGCMMessage();
		$this->apns = new KiiAPNsMessage();
	}

	public function setSendToDevelopment($value) {
		$this->sendToDevelopment =$value;
	}

	public function setSendToProduction($value) {
		$this->sendToProduction = $value;
	}

	public function setPushMessageType($value) {
		$this->pushMessageType = $value;
	}

	public function setSendAppID($value) {
		$this->sendAppID =$value;
	}

	public function setSendSender($value) {
		$this->sendSender = $value;
	}

	public function setSendWhen($value) {
		$this->sendWhen = $value;
	}
	public function setSSendOrigin($value) {
		$this->sendOrigin = $value;
	}

	public function setSendObjectScope($value) {
		$this->sendObjectScope = $value;
	}

	public function setSendTopicID($value) {
		$this->sendTopicID = $value;
	}

	public function toJson() {
		$json = array(
					  "sendToDevelopment" => $this->sendToDevelopment,
					  "sendToProduction" => $this->sendToProduction,
					  "pushMessageType" => $this->pushMessageType,
					  "sendAppID" => $this->sendAppID,
					  "sendSender" => $this->sendSender,
					  "sendWhen" => $this->sendWhen,
					  "sendOrigin" => $this->sendOrigin,
					  "sendObjectScope" => $this->sendObjectScope,
					  "sendTopicID" => $this->sendTopicID,
					  
					  "gcm" => $this->gcm->toJson(),
					  "apns" => $this->apns->toJson()
					  );
		if (count($this->data) > 0) {
			$json['data'] = $this->data;
		}
		return $json;
	}
}
?>