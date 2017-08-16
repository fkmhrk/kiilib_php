<?php
interface HttpResponse {
	public function getStatus();

	public function getAllHeaders();
			
	public function getAsJson() : array ;
}
?>