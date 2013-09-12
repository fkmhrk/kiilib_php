<?php
require_once (dirname(__FILE__). '/../../HttpClientFactory.php');
require_once (dirname(__FILE__). '/KiiHttpClient.php');

class KiiHttpClientFactory implements HttpClientFactory {
	public function newClient() {
		return new KiiHttpClient();
	}
}

?>