<?php

require("Test.php");

class HaTest extends \Lemonade\Test{

	public function teste(){
		$a = new ProdutosController();
		$this->assertEquals(1, $a->retorna());
	}

}
