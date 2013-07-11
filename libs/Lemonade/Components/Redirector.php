<?php
/**
* Redirector System
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/
namespace Lemonade\Components;

class Redirector{

	/**
	* Redirect 
	* @access private
	* @param string $url for redirect
	* @return Void
	*/ 
	private static function go($url){
		$media = "";
		if(\Lemonade\Registry::Get("config")->debug == "true"){
			$nameDir = explode(DIRECTORY_SEPARATOR, DIR);
			header("Location: /" . end($nameDir) . DIRECTORY_SEPARATOR . $url);
		}else{
			header("Location: /" . $url);
		}
	}

	/**
	* Redirect for other controller or/and action
	* @access public
	* @param array $data data for redirect
	* @return Void
	*/
	public static function redirect($data){
		$controller = (isset($data["controller"]) ? $data["controller"] : \Lemonade\Route::getController());
		$action = (isset($data["action"]) ? $data["action"] : "index");
		$params = (isset($data["param"]) ? implode("/", $data["param"]) : "");
		self::go($controller . "/" . $action . "/" . $params);
	}

	/**
	 * Redirect to login
	 * @access public
	 * @return Void
	 */
	public static function login(Array $next){
		$url = explode("/", \Lemonade\Registry::Get("auth")->url_login);
		self::redirect(array("controller"=> $url[0], "action" => $url[1], "param" => $next));
	}

	/**
	* Redirect for other site
	* @access public
	* @param string $url url for redirect
	* @return Void
	*/
	public static function goToUrl($url){
		header("Location: " . $url);
	}

}