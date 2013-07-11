<?php
define("DIR", __DIR__ . "/../");
require_once("../libs/Lemonade/Lemonade.php");

class TesteTest extends PHPUnit_Framework_TestCase{

	public function testCerto(){
		$model = new \Lemonade\Lemonade();
		$engine = \Lemonade\Registry::Get("config")->engine_template;
		$this->assertEquals($engine, "lemonade");
	}

}