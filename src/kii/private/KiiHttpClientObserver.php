<?php
class KiiHttpClientObserver implements SplObserver {
	private $fp;

	public function __construct($fp) {
		$this->fp = $fp;
	}

	public function update(SplSubject $subject) {
        $event = $subject->getLastEvent();

        switch ($event['name']) {
        case 'receivedBodyPart':
        case 'receivedEncodedBodyPart':
            fwrite($this->fp, $event['data']);
            break;
        case 'receivedBody':
			# nop
			break;
        }
    }
}
?>