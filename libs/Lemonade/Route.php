<?php

/**
* Class for Route framework
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/
namespace Lemonade;

class Route{

	/**
	*@var string	
	*@access private
	*/
	private static $controller;

	/**
	*@var string	
	*@access private
	*/
	private static $action;

	/**
	*@var string	
	*@access private
	*/
	private $url;

	/**
	*@var Array
	*@access private
	*/
	private $explode;

	/**
	*@var string	
	*@access private
	*/
	private static $params;

	/**
     * construct
     * @access public
     * @return Void
     */
	public function __construct(){
		$this->setUrl();
		$this->setExplode();
		$this->setController();
		$this->setAction();
		$this->setParams();
		$this->defineMedia();
	}

	/**
	 * Define url media
	 * @access private
	 * @return Void
	 */
	private function defineMedia(){
		$media = "";
		if(\Lemonade\Registry::Get("config")->debug == "true"){
			$nameDir = explode(DIRECTORY_SEPARATOR, DIR);
			$media .= DIRECTORY_SEPARATOR . end($nameDir) . DIRECTORY_SEPARATOR . "app";
		}
		$media .= DIRECTORY_SEPARATOR . \Lemonade\Registry::Get("config")->media_folder . DIRECTORY_SEPARATOR;
		define("MEDIA", $media);
	}

	/**
     * Set URL correct
     * @access private
     * @return Void
     */
	private function setUrl(){
		$this->url = (isset($_GET["url"]) ? $_GET["url"]."/" : "index/index");
	}

	/**
     * Set data of URL
     * @access private
     * @return Void
     */
	private function setExplode(){
		$this->explode = explode("/", $this->url);
	}

	/**
     * Set application controller
     * @access private
     * @return Void
     */
	private function setController(){
		self::$controller = $this->explode[0];
	}

	/**
     * Get application controller
     * @access public
     * @return String Controller in use
     */
	public static function getController(){
		return self::$controller;
	}

	/**
     * Set application action
     * @access private
     * @return Void
     */
	private function setAction(){
		$ac = (!isset($this->explode[1]) || $this->explode[1] == null ? "index" : $this->explode[1]);
		self::$action = $ac;
	}

	/**
     * Get application action
     * @access public
     * @return string Action in use
     */
	public static function getAction(){
		return self::$action;
	}

	/**
     * Set parameter of URL
     * @access private
     * @return Void
     */
	private function setParams(){
		self::$params = $this->explode;
		unset(self::$params[0], self::$params[1]);
		if(end(self::$params) == null){
			array_pop(self::$params);
		}
	}

	/**
     * Get parameter of URL
     * @access public
     * @return array
     */
	public static function getParam(){
		return self::$params;
	}
}