<?php

/**
* Class for Response framework
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/
namespace Lemonade;

class Response{

	/**
	* Redirect for other controller or/and action
	* @access public
	* @param array $data data for redirect
	* @return Void
	*/
	public function redirect(Array $data = null){
		\Lemonade\Components\Redirector::redirect($data);
	}

	/**
	* Redirect for other site
	* @access public
	* @param string $url url for redirect
	* @return Void
	*/
	public function goToUrl($url){
		\Lemonade\Components\Redirector::goToUrl($url);
	}

}