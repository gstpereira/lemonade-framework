<?php

/**
* Class for Request framework
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/
namespace Lemonade;

class Request{

	/**
	* @var \Lemonade\Components\Session
	* @access public
	*/
	public $session;

	/**
	* @var \Lemonade\Components\Cookie
	* @access public
	*/
	public $cookie;

	/**
	* Construct
	* @access public
	* @param Array $components Components for instance
	* @return Void
	*/
	public function __construct(Array $components){
		$this->setComponents($components);
	}

	/**
	* Set components the Request
	* @access private
	* @param Array $components Components for instance
	* @return Void
	*/
	private function setComponents($components){
		$thisComponents = array("session","cookie");
		foreach ($components as $val) {
			if(in_array($val, $thisComponents)){
				$component = "\Lemonade\Components\\" . ucwords($val);
				$this->$val = new $component;
			}
		}
	}

	/**
     * this is POST request
     * @access public
     * @return bool
     */
	public function isPost(){
		return $this->getMethod() == 'POST';
	}

	/**
     * this is GET request
     * @access public
     * @return bool
     */
	public function isGet(){
		return $this->getMethod() == 'GET';
	}
	
	/**
	* Get data in $_POST
	* @access public
	* @param $name String name of index post
	* @return string/int/array
	*/
	public function getPost($name = null){
		if($this->isPost()){
			if(!is_null($name)){
				if(array_key_exists($name, $_POST)){
					return $_POST[$name];
				}else{
					return null;
				}
			}else{
				return $_POST;
			}
		}
		return null;
	}

	/**
	* Get data in $_FILES
	* @access public
	* @param $name String name of index files
	* @return string/int/array
	*/
	public function getFile($name = null){
		if($this->isPost()){
			if(!is_null($name)){
				if(array_key_exists($name, $_FILES)){
					return $_FILES[$name];
				}else{
					return null;
				}
			}else{
				return $_FILES;
			}
		}
		return null;
	}

	/**
	* Get method
	* @access public
	* @return string
	*/
	public function getMethod(){
		return self::requestMethod();
	}

	/**
	 * Get method for request
	 * @access public
	 * @return string
	 */
	public static function requestMethod(){
		return $_SERVER["REQUEST_METHOD"];
	}

}