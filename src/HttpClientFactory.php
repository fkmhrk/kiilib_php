<?php

interface HttpClientFactory {
	public function newClient() : HttpClient;
}
?>