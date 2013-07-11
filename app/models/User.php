<?php

class User extends \Lemonade\Auth\User{
	static $table = "tb_login";
	static $userColumn = "login";
	static $passColumn = "senha";
}