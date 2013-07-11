<?php
/**
* Session System
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/
namespace Lemonade\Components;

class Session{

	/**
	 * Create the session / construct
	 * @access public
	 * @return Void
	 */
	public function __construct(){
		if(!strlen(session_id()) && \Lemonade\Registry::Get("app")){
			session_start();
		}
	}

	/**
	* Create session 
	* @access public
	* @param string $name name for session
	* @param string $value value for session
	* @return Obj thiss
	*/
	public function set($name, $value){
		$_SESSION[$name] = $value;
		return $this;
	}
	
	/**
	* Get session
	* @access public
	* @param string $name name for select session
	* @return Obj this
	*/
	public function get($name){
		if($this->check($name)){
			return $_SESSION[$name];
		}
		return $this;
	}
	
	/**
	* delete session
	* @access public
	* @param string $name delete session for name
	* @return Obj this
	*/
	public function delete($name = null){
		if(!is_null($name)){
			unset($_SESSION[$name]);
		}else{
			session_destroy();
		}
		return $this;
	}

	/**
	* check is exists session
	* @access public
	* @param string $name name for de check session
	* @return Obj this
	*/
	public function check($name){
		return isset($_SESSION[$name]);
	}

}