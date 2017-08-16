<?php
interface HttpResponse {
	public function getStatus() : int;

	public function getAllHeaders() : array;
			
	public function getAsJson() : array ;
}
?>