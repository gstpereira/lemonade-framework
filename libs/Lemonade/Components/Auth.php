<?php

/**
* Auth System
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/

namespace Lemonade\Components;

class Auth{

	/**
	 * Session
	 * @var \Lemonade\Components\Session
	 */
	private $session;

	/**
	 * Construct
	 * @access public
	 * @return Void
	 */
	public function __construct(){
		$this->session = new \Lemonade\Components\Session();
		$this->check();
	}

	/**
	 * Create session for auth
	 * @access private
	 * @param  string $user data for user serailize
	 * @return Void
	 */
	private function createSession($user){
		$this->session->set("auth_user", $user);
	}

	/**
	 * Method for do login
	 * @access public
	 * @param  string $user     user for login
	 * @param  string  $password password for login
	 * @return bool if login
	 */
	public  function login($user, $password){
		$model =  \Lemonade\Registry::Get("auth")->model;
		$userModel = new $model();
		$user = $userModel->getUser($user,$password);
		if(!is_null($user)){
			$user = serialize(array("user" => $user));
			$this->createSession($user);
			if(count(\Lemonade\Route::getParam()) > 0){
				$param = \Lemonade\Route::getParam();
				if(reset($param) != null){
					$url["controller"] = reset($param);
					if(next($param) != null){
						$url["action"] = current($param);
					}
					\Lemonade\Components\Redirector::redirect($url);
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * Check login in controller
	 * @access private
	 * @return bool if user logged
	 */
	private function check(){
		$urlLogin = ((\Lemonade\Registry::Get("auth")->url_login) == \Lemonade\Route::getController() . "/" . \Lemonade\Route::getAction());
		$urlLogout = ((\Lemonade\Registry::Get("auth")->url_logout) == \Lemonade\Route::getController() . "/" . \Lemonade\Route::getAction());
		if(!$this->session->check("auth_user") && \Lemonade\Annotation::checkRequiredLogin() && !$urlLogin && !$urlLogout){
			\Lemonade\Components\Redirector::login(array(\Lemonade\Route::getController(), \Lemonade\Route::getAction()));
			return true;
		}
		return false;
	}

	/**
	 * logout user
	 * @access public
	 * @return Void
	 */
	public function logout(){
		$this->session->delete("auth_user");
		\Lemonade\Components\Redirector::login();
	}

	/**
	 * Get user logged
	 * @access public
	 * @return Obj User
	 */
	public function getUser(){
		$user = unserialize($this->session->get("auth_user"));
		return $user["user"];
	}

}
