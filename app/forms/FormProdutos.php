<?php

class FormProdutos extends \Lemonade\Components\Form{

	static $fields = array(
			"login" => array(
				"type" => "email",
				"value" => "default",
				"option" => array(
						"id" => "teste",
					),
				"validate" => array("required"),
			),
			"senha" => array(
				"type" => "select",
				"value" => array(
						"volvo" => "Caminhões volvo",
						"mercedes" => "Caminhões mercedes",
						"audi" => "Caminhões audi",
					),
				"option" => array(
						"id" => "teste",
					),
			),
			"logado" => array(
				"type" => "checkbox",
				"value" => "default",
				"option" => array(
						"id" => "teste",
					),
			),
		);


}