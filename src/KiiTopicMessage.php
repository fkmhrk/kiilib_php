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

	public function __construct()
    {
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

	public function setSendToDevelopment(bool $value) 
    {
		$this->sendToDevelopment = $value;
	}

	public function setSendToProduction(bool $value)
    {
		$this->sendToProduction = $value;
	}

	public function setPushMessageType(string $value)
    {
		$this->pushMessageType = $value;
	}

	public function setSendAppID(bool $value)
    {
		$this->sendAppID =$value;
	}

	public function setSendSender(bool $value)
    {
		$this->sendSender = $value;
	}

	public function setSendWhen(bool $value)
    {
		$this->sendWhen = $value;
	}
    
	public function setSendOrigin(bool $value)
    {
		$this->sendOrigin = $value;
	}

	public function setSendObjectScope(bool $value)
    {
		$this->sendObjectScope = $value;
	}

	public function setSendTopicID(bool $value)
    {
		$this->sendTopicID = $value;
	}

	public function toJson() : array
    {
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