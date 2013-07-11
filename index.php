<?php
	header('Content-type: text/html; charset=utf-8');
	define("DIR", __DIR__);

	require_once("libs/Lemonade/Lemonade.php");
	$start = new \Lemonade\Lemonade();
	$start->run();