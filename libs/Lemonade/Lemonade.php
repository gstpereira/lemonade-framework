<?php

/**
* Class Principal framework
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/

namespace Lemonade;

class Lemonade{

	/**
	 * Path the controller
	 * @access private
	 * @var string
	 */
	private static $controller_path;

	/**
     * construct
     * @access public
     * @return Void
     */
	public function __construct($app = true){
		self::registerAutoloader();
		set_error_handler(array(new \Lemonade\Erro(),"treatmentError"));
		set_exception_handler(array(new \Lemonade\Erro(),"treatmentException"));
		require_once __DIR__ . DIRECTORY_SEPARATOR . "Utils.php";
		new \Lemonade\Config($this->getAppDir() . \Lemonade\Config::ARCHIVE_CONFIG);
		\Lemonade\Registry::Set("app", $app);
		new \Lemonade\Route();
	}

	/**
     * Lemonade autoloader
     * @access public
     * @param string name of class for instance
     * @return Void
     */
	public static function autoload($name){
        $class = str_replace(__NAMESPACE__.'\\', '', __CLASS__);
        $dir = __DIR__;
        if (substr($dir, -strlen($class)) === $class) {
            $dir = substr($dir, 0, -strlen($class));
        }
        $name = ltrim($name, '\\');
        $file  = $dir;
        $namespace = '';
        if ($lastNsPos = strripos($name, '\\')) {
            $namespace = substr($name, 0, $lastNsPos);
            $name = substr($name, $lastNsPos + 1);
            $file  .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $file .= $name . '.php';
        if(file_exists($file)){
        	require_once $file;
        }
	}

	/**
     * Lemonade App autoloader
     * @access public
     * @param string name of class for instance
     * @return Void
     */
	public static function autoloadApp($name){
		$model_path = self::getAppDir() . "models" . DIRECTORY_SEPARATOR . ucwords($name) . ".php";
		$form_path = self::getAppDir() . "forms" . DIRECTORY_SEPARATOR . ucwords($name) . ".php";
		$helper_path = self::getAppDir() . "helpers" . DIRECTORY_SEPARATOR . ucwords($name) . ".php";
		if(file_exists($model_path)){
			require_once $model_path;
		}else if(file_exists($form_path)){
			require_once $form_path;
		}else if(file_exists($helper_path)){
			require_once $helper_path;
		}else if(file_exists(self::$controller_path)){
			require_once self::$controller_path;
		}
	}

	/**
     * Directory of Lemonade App
     * @access public
     * @return String Directory the app
     */
	public static function getAppDir(){
		return DIR . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR;
	}

	/**
     * Register Lemonade autoloader
     * @access public
     * @return Void
     */
	public static function registerAutoloader(){
		spl_autoload_register(__NAMESPACE__ . "\\Lemonade::autoload");
		spl_autoload_register(__NAMESPACE__ . "\\Lemonade::autoloadApp");
	}

	/**
     * Run Lemonade
     * @access public
     * @return Void
     */
	public function run(){
		self::$controller_path = self::getAppDir() . "controllers" . DIRECTORY_SEPARATOR . ucwords(\Lemonade\Route::getController()) . "Controller.php";
		if(!file_exists(self::$controller_path)){
			throw new \Exception("Controller não encontrado");
		}
		$controller = ucwords(\Lemonade\Route::getController()) . "Controller";
		$app = new $controller;
		if(!method_exists($app, \Lemonade\Route::getAction())){
			throw new \Exception("Action não encontrada");
		}
		if(\Lemonade\Annotation::checkAccess()){
			call_user_func_array(array($app,"init"), array());
			call_user_func_array(array($app, \Lemonade\Route::getAction()), \Lemonade\Route::getParam());
		}else{
			throw new \Exception("Action não encontrada");
		}
	}
}