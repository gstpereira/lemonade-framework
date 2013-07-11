<?php

/**
* Class for Controller framework
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/

namespace Lemonade;

class Controller{

	/**
	* @access protected
	* @var \Lemonade\Request	
	*/
	protected $request;

	/**
	* @access protected
	* @var \Lemonade\Response	
	*/
	protected $response;

	/**
	* @access protected
	* @var \Lemonade\Components\Validator
	*/
	protected $validator;

	/**
	* @access protected
	* @var \Lemonade\Components\Cache
	*/
	protected $cache;

	/**
	* @access protected
	* @var \Lemonade\Components\Mail
	*/
	protected $mail;

	/**
	* @access protected
	* @var \Lemonade\Components\Paginator
	*/
	protected $paginator;

	/**
	* @access protected
	* @var \Lemonade\Components\Upload
	*/
	protected $upload;

	/**
	* @access protected
	* @var \Lemonade\Components\Auth
	*/
	protected $auth;

	/**
	* @access protected
	* @var String
	*/
	protected $appDir;

	/**
	* @access protected
	* @var Array
	*/
	protected $components = array();

	/**
	* construct
	* @access public
	* @return Void
	*/
	public function __construct(){
		$this->appDir = \Lemonade\Lemonade::getAppDir();
		$this->request = new \Lemonade\Request($this->components);
		$this->response = new \Lemonade\Response();
		$this->setComponents();
	}	

	/**
	* Set components the controller
	* @access private
	* @return Void
	*/
	private function setComponents(){
		$componentsForeign = array("session","cookie","redirector");
		foreach ($this->components as $val) {
			if(!in_array($val, $componentsForeign)){
				$component = "\Lemonade\Components\\" . ucwords($val);
				$this->$val = new $component;
			}
		}
	}

	/**
     * render view using engine template
     * @access protected
     * @param string name of template
     * @param array data for templates
     * @return Void
     */
	protected function view($template, Array $data = null){
		if(!is_null($data))
			\Lemonade\View::$data = $data;
		\Lemonade\View::$template = $template;
		\Lemonade\View::factory(\Lemonade\Registry::Get(\Lemonade\Config::NAME_CONFIG_REGISTRY));
		exit();
	}

	/**
     * render view using ajax
     * @access protected
     * @param array/string data for templates
     * @return Void
     */
	protected function ajax($data){
		echo json_encode($data);
		exit();
	}

	/**
     * Method always execute first 
     * @access public
     * @return Void
     */
	public function init(){}

}