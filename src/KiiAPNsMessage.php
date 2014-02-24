<?php

class KiiAPNsMessage {
	public $data;
    private $alert;
	private $enable;
    private $badge;
    
    public function __construct() {
        $this->data = array();
        $this->alert = array();
        $this->enable = TRUE;
        $this->badge = 0;
    }

    public function setEnabled($value) {
        $this->enable = $value;
    }

    public function setBadge($value) {
        $this->badge = $value;
    }

    public function setBody($value) {
        $this->alert['body'] = $value;
    }

    public function toJson() {
        $json = array(
                      "enabled" => $this->enable,
                      'badge' => $this->badge
                      );
        if (count($this->data) > 0) {
            $json['data'] = $this->data;
        }
        if (count($this->alert) > 0) {
            $json['alert'] = $this->alert;
        }        

        return $json;
    }
}
?>