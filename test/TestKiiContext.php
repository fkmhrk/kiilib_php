<?php
require '../src/KiiContext.php';

class TestKiiContext extends PHPUnit_Framework_TestCase{
	public function test_0000_construct() {
		$appId = 'app0000';
		$appKey = 'key0000';
		
		$context = new KiiContext($appId, $appKey, KiiContext::SITE_US);
		// assertion
		$this->assertEquals('app0000', $context->getAppId());
		$this->assertEquals('key0000', $context->getAppKey());
		$this->assertEquals('https://api.kii.com/api', $context->getServerUrl());
	}

	public function test_0001_construct_JP() {
		$appId = 'app0000';
		$appKey = 'key0000';
		
		$context = new KiiContext($appId, $appKey, KiiContext::SITE_JP);
		// assertion
		$this->assertEquals('app0000', $context->getAppId());
		$this->assertEquals('key0000', $context->getAppKey());
		$this->assertEquals('https://api-jp.kii.com/api', $context->getServerUrl());
	}
	
	public function test_0002_construct_CN() {
		$appId = 'app0000';
		$appKey = 'key0000';
		
		$context = new KiiContext($appId, $appKey, KiiContext::SITE_CN);
		// assertion
		$this->assertEquals('app0000', $context->getAppId());
		$this->assertEquals('key0000', $context->getAppKey());
		$this->assertEquals('https://api-cn2.kii.com/api', $context->getServerUrl());
	}
}
?>