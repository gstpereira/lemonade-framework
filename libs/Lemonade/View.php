<?php
/**
* Class for View framework
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/
namespace Lemonade;

class View{

	/**
	* @var Array
	* @access public
	*/
	public static $data = array();

	/**
	* @var string
	* @access public
	*/
	public static $template = null;

	/**
	 * Directory of libs
	 * @access private
	 * @var string
	 */
	private static $dirLibs;

	/**
	* Factory for render to view
	* @access public
	* @param $type String
	* @return Void
	*/
	public static function factory($config){
		self::$data["media"] = MEDIA;
		self::$dirLibs = str_replace(__NAMESPACE__, '', __DIR__);
		$method = strtolower($config->engine_template) . 'View';
		if(method_exists("\Lemonade\View", $method)){
			self::$method();	
		}else{
			self::LemonadeView();
		}
	}

	/**
	* Method for render to twig
	* @access private
	* @return Void
	*/
	private static function twigView(){
		if(!file_exists(self::$dirLibs."Twig/Autoloader.php")){
			throw new  \Exception("Framework não instalado ou em diretório diferente");
		}
		require_once(self::$dirLibs."Twig/Autoloader.php");
		\Twig_Autoloader::register();
		$loader = new \Twig_Loader_Filesystem(\Lemonade\Lemonade::getAppDir() . "templates");
		if(\Lemonade\Registry::Get("config")->cache_template == "true"){
			$data["cache"] = \Lemonade\Lemonade::getAppDir() . "cache" . DIRECTORY_SEPARATOR . \Lemonade\Registry::Get("config")->template_cache_folder;
		}
		$data["auto_reload"] = true;
		$data["autoescape"] = false;
		$twig = new \Twig_Environment($loader, $data);
		$template = $twig->render(\Lemonade\Route::getController() . DIRECTORY_SEPARATOR . self::$template.".phtml", self::$data);
		echo $template;
	}
	
	/**
	* Method for render to smarty
	* @access private
	* @return Void
	*/
	private static function smartyView(){
		if(!file_exists(self::$dirLibs."Smarty/Smarty.class.php")){
			throw new  \Exception("Framework não instalado ou em diretório diferente");
		}
		require_once(self::$dirLibs."Smarty/Smarty.class.php");
		$smarty = new \Smarty;
		$smarty->template_dir = \Lemonade\Lemonade::getAppDir() . "templates";
		$smarty->compile_dir = \Lemonade\Lemonade::getAppDir() . \Lemonade\Registry::Get("config")->compile_folder;
		$smarty->config_dir = \Lemonade\Lemonade::getAppDir() . \Lemonade\Registry::Get("config")->config_folder;
		$smarty->cache_dir = \Lemonade\Lemonade::getAppDir() . \Lemonade\Registry::Get("config")->template_cache_folder;
		foreach (self::$data as $key => $val) {
			$smarty->assign($key, $val);
		}
		$smarty->cache = (\Lemonade\Registry::Get("config")->cache_template == "true") ? true : false;
		$smarty->display(\Lemonade\Route::getController() . DIRECTORY_SEPARATOR . self::$template.".phtml");
	}

	/**
	* Method for render view in default
	* @access private
	* @return Void
	*/
	private static function LemonadeView(){
		if(count(self::$data)){
			extract(self::$data, EXTR_PREFIX_SAME, "Lemonade");
		}
		require_once(\Lemonade\Lemonade::getAppDir() . "templates" . DIRECTORY_SEPARATOR . \Lemonade\Route::getController() . DIRECTORY_SEPARATOR . self::$template . ".phtml");
	}

}