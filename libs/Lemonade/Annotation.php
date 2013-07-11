<?php

/**
* Annotation System
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/

namespace Lemonade;

class Annotation{

	/**
	 * const for annotation access method
	 */
	const METHOD = "@method(";

	/**
	 * const for annotation login required
	 */
	const LOGIN = "@login_required(";

	/**
	 * Get Method Documentation 
	 * @access private
	 * @param  string $controller Controller for get method
	 * @param  string $action     method for get documentation
	 * @param  string $annotation annotation for get
	 * @param  Array  $default    value default for return
	 * @return Array             value for documentation or default
	 */
	private static function getMethodDoc($controller, $action, $annotation, Array $default){
		$class = new \ReflectionClass($controller);
		$method = $class->getMethod($action)->getDocComment();
		$pos = strpos($method, $annotation);
		if($pos !== false){
			$type = trim(substr($method, $pos + strlen($annotation)));
			$type = substr($type, 0, strpos($type, ")") - strlen($type));
			return array_map("trim", explode(",", $type));
		}else{
			return $default;
		}
	}

	/**
	 * Get anntation value for required login
	 * @access private
	 * @param  string $controller Controller for get method
	 * @param  string $action     method for get documentation
	 * @return bool             if required or not
	 */
	private static function getRequiredLogin($controller, $action){
		$return = self::getMethodDoc($controller, $action, self::LOGIN, array("true"));
		return ($return[0] == "true") ? true : false;;
	}

	/**
	 * Get annotation value for access method
	 * @access private
	 * @param  string $controller Controller for get method
	 * @param  string $action     method for get documentatin
	 * @return Array             methods for access action
	 */
	private static function getMethod($controller, $action){
		return self::getMethodDoc($controller, $action, self::METHOD, array("post", "get"));
	}

	/**
	 * Check the annotation required login
	 * @access public
	 * @return bool if required or not
	 */
	public static function checkRequiredLogin(){
		if(\Lemonade\Registry::Get("app")){
			return self::getRequiredLogin(\Lemonade\Route::getController() . "Controller", \Lemonade\Route::getAction());
		}
	}

	/**
	 * Check access in action
	 * @access public
	 * @return Array type access accepted in method
	 */
	public static function checkAccess(){
		if(\Lemonade\Registry::Get("app")){
			return in_array(strtolower(\Lemonade\Request::requestMethod()), self::getMethod(\Lemonade\Route::getController() . "Controller", \Lemonade\Route::getAction()));
		}
	}

}