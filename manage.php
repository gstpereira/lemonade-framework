<?php
	require_once("libs/Lemonade/Manage/Manage.php");
	define("DIR", __DIR__);
	\Lemonade\Manage\Manage::factory($argv);
