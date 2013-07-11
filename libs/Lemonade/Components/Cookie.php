<?php
/**
* Cookie System
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/

namespace Lemonade\Components;

class Cookie{

	/**
	 * Set cookie
	 * @access public
	 * @param String  $name   nem th cookie
	 * @param String  $value  value the cookie
	 * @param integer $time   time of life cookie
	 * @param string  $path   path for cookie
	 * @param String  $domain domain of cookie
	 * @param boolean $secure if secure
	 */
	public function set($name, $value, $time = 0, $path = "/", $domain = $_SERVER["SERVER_NAME"], $secure = false){
		setcookie($name, $value, $time, $path, $domain, $secure);
	}

	/**
	 * get cookie
	 * @access public
	 * @param  string $name index for cookie
	 * @return String       cookie with index
	 */
	public function get($name){
		if($this->checkCookie($name)){
			return $_COOKIE[$name];
		}
		return $this;
	}
	
	/**
	* delete cookie
	* @access public
	* @param string $name delete cookie for name
	* @return Obj this
	*/
	public function delete($name){
		if($this->checkCookie($name)){
			setcookie($name,"",1);
		}
		return $this;
	}

	/**
	* check is exists cookie
	* @access public
	* @param string $name name for de check cookie
	* @return bool if exist cookie with index
	*/
	public function check($name){
		return isset($_COOKIE[$name]);
	}

}