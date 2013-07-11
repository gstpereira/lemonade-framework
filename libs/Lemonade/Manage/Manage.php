<?php

namespace Lemonade\Manage;

class Manage{

	/**
	* Text for wirte in new file 
	* @access private
	* @var array
	*/
	private static $text = array(
			"controllers" => "<?php\n\nclass %s extends \Lemonade\Controller{\n\n\tpublic function index(){\n\n\t}\n\n}\n",
			"models" => "<?php\n\nclass %s extends \Lemonade\Model{\n\n\t static \$table = \" \";\n\n}\n",
			"helpers" => "<?php\n\nclass %s{\n\n}\n",
			"tests" => "<?php\n\nrequire(\"Test.php\");\n\nclass %s extends \Lemonade\Test{\n\n}\n",
			"forms" => "<?php\n\nclass %s extends \Lemonade\Components\Form{\n\n\t static \$fields = array();\n\n}\n",
		);

	/**
	* Controller if error 
	* @access private
	* @var bool
	*/
	private static $status = true;

	/**
	* Construct private because force using factory
	* @access private
	* @return Void
	*/
	private function __construct(){}

	/**
	* factory for using in class
	* @access public
	* @return Void
	*/
	public static function factory(Array $args){
		if(method_exists("\Lemonade\Manage\Manage", strtolower($args[1]))){
			$action = strtolower($args[1]);
			self::$action($args);
		}else{
			self::help($args);
		}
	}

	/**
     * Directory of Lemonade App
     * @access private
     * @return string
     */
	private static function getAppDir(){
		return dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR;
	}

	/**
	* Clear archives and folder case error
	* @access private
	* @return Void
	*/
	private static function clearAll($nameApp){
		foreach (self::$text as $key => $val) {
			if(in_array($key, array("controllers","models"))){
				$filename = ($key == "controllers") ? $nameApp . "Controller" : $nameApp ;
				$filename = self::getAppDir() . $key . DIRECTORY_SEPARATOR . $filename.".php";
				if(file_exists($filename)){
					unlink($filename);
				}
			}
		}
		self::$status = false;		
	}

	/**
	* Create archives
	* @access private
	* @param string $nameApp name of app
	* @param string $type type of archive(model or controller)
	* @return Void
	*/
	private static function createFile($nameApp, $type){
		if($type != "models"){
			$filename = $nameApp . ucwords(substr($type, 0, -1));
		}else{
			$filename = $nameApp;
		}
		$text = sprintf(self::$text[$type],$filename);
		$filename = self::getAppDir() . $type . DIRECTORY_SEPARATOR . $filename.".php";
		if(!file_exists($filename)){
			$file = @fopen($filename, "w+");
			if($file){
				if(@fwrite($file, $text)){
					if(!@fclose($file)){
						self::clearAll($nameApp);
					}
				}else{
					self::clearAll($nameApp);
				}
			}else{
				self::clearAll($nameApp);
			}
		}
	}

	/**
	 * Create file template
	 * @access private
	 * @param Array $args data for create template
	 * @return Void
	 */
	private static function createTemplate(Array $args){
		$fileDir = (isset($args[4]) && !is_null($args[4])) ? $args[3] . DIRECTORY_SEPARATOR . $args[4] : $args[3];
		$filename = self::getAppDir() . "templates" . DIRECTORY_SEPARATOR . $fileDir . ".phtml";
		if(!file_exists($filename)){
			$file = @fopen($filename, "w+");
			if($file){
				@fclose($file);
			}
		}
	}

	/**
	* Create archive and folder for app
	* @access private
	* @return Void
	*/
	private static function start(Array $args){
		switch ($args[2]) {
			case "app":
				self::app($args);
				break;
			case "model";
			case "controller";
			case "helper";
			case "test";
			case "form":
				self::singleFile($args);
				break;
			case "template":
				self::createTemplate($args);
				break;
			default:
				self::help();
				break;
		}
	}

	/**
	* Create archive and folder for app
	* @access private
	* @return Void
	*/
	private static function app(Array $args){
		if(isset($args[3]) && !empty($args[3])){
			$i = 0;
			$key = array_keys(self::$text);
			$less = (isset($args[4])) ? substr($args[4], 1) . "s" : " ";
			while (self::$status && $i < 2) {
				if($less != $key[$i]){
					self::createFile(ucwords($args[3]), $key[$i]);
				}
				$i++;
			}
			if(self::$status && $less != "templates"){
				mkdir(self::getAppDir() . "templates" . DIRECTORY_SEPARATOR . $args[3], 0777, true);
			}
		}else{
			echo "Digite o nome da app para criar\n";
		}
	}

	/**
	* Create single file
	* @access private
	* @return Void
	*/
	private static function singleFile(Array $args){
		if(isset($args[3]) && !empty($args[3])){
			self::createFile(ucwords($args[3]), $args[2] . "s");
		}else{
			echo "Digite o nome do " . $args[2] . " para criar\n";
		}
	}

	/**
	 * Call function for clear the project
	 * @return Void
	 */
	private static function clear(){
		self::clearProject(DIR, DIR . DIRECTORY_SEPARATOR . "target");
	}

	/**
	 * Clear the project for production
	 * @access private
	 * @param  strng $origin origin the project
	 * @param  string $destin destin the project
	 * @return Void
	 */
	private static function clearProject($origin, $destin){
		if (is_dir( $origin )) {
			@mkdir($destin);
			$dir = dir($origin);
			$clear = array("target", "tests", "manage.php", "Manage", ".svn");
			while (false !== ($entry = $dir->read())) {
				if(!in_array($entry, $clear)){
					if($entry == '.' || $entry == '..'){
						continue;
					}
					$newEntry = $origin . DIRECTORY_SEPARATOR . $entry;
					if (is_dir($newEntry)){
						self::clearProject($newEntry, $destin . DIRECTORY_SEPARATOR . $entry);
						continue;
					}
					copy($newEntry, $destin . '/' . $entry);
				}
			}
	 
			$dir->close();
		}
	}


	/**
	* Method for print HELP
	* @access private
	* @return Void
	*/
	private static function help(){
		$help = "\tHELP\n\n";
		$help .= "\t[start]\n";
		$help .= "\t\t[app] = Cria um novo app(Controller, Model e pasta de template)\n";
		$help .= "\t\t[controller] = Cria um novo arquivo Controller\n";
		$help .= "\t\t[model] = Cria um novo arquivo Model\n";
		$help .= "\t\t[form] = Cria um novo arquivo formulario\n";
		$help .= "\t\t[test] = Cria um novo arquivo de test\n";
		$help .= "\t\t[helper] = Cria um novo arquivo de helper\n\n";
		$help .= "\t[clear] = Limpa o projeto retirando os testes e outros arquivos para ser colocado em produção\n";
		echo "\n";
		echo($help);
	}

}