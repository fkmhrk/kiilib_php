<?php
interface HttpResponse {
	public function getStatus();

	public function getAsJson();
}
?>