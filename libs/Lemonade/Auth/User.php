<?php

/**
* Class for Set basic User in framework
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/
namespace Lemonade\Auth;

class User extends \Lemonade\Model{

	/**
	 * name the table in database
	 * @var string $table
	 */
	static $table = "tb_user";

	/**
	 * name the user column in database
	 * @var string $userColumn
	 */
	static $userColumn = "user";

	/**
	 * name the password column in database
	 * @var string $passColumn
	 */
	static $passColumn = "password";

	/**
	 * name the primary key column in database
	 * @var string $idColumn
	 */
	static $idColumn = "id";

	/**
	 * Get user
	 * @access public
	 * @param  string $user     user for search
	 * @param  string  $password password for search 
	 * @return Obj           User 
	 */
	public function getUser($user, $password){
		return self::get(array("where" => static::$userColumn . "='" . $user . "' AND " . static::$passColumn . "='" . $password . "'", "fields" => array(static::$idColumn, static::$userColumn)));
	}

}