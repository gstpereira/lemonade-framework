<?php

/**
* Class for Config framework
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/

namespace Lemonade;

class Config{

	/**
	* Constant for name the session in archive config
	*/
	const NAME_CONFIG_REGISTRY = "config";

	/**
	* Constant for name the session in archive config
	*/
	const NAME_DB_REGISTRY = "db";

	/**
	* Constant for name the archive config
	*/
	const ARCHIVE_CONFIG = "config.ini";

	/**
	* @var array/stdClass
	* @access private
	*/
	private $fileContents = array();

	/**
	* construct
	* @access public
	* @return Void
	*/
	public function __construct($file){
		$this->loadFile($file);
		$this->registryConfig();
		$this->setConfig();
		$this->registryCommandSql();
	}

	/**
	* Set basic config
	* @access private
	* @return Void
	*/
	private function setConfig(){
		if(\Lemonade\Registry::Get("config")->debug == "false"){
			ini_set('display_errors', '0');
		}
	}

	/**
	* Load file .ini
	* @access private
	* @return Void
	*/
	private function loadFile($file){
		if (!file_exists($file))
    	    throw new \Exception("O arquivo de configuração não existe ou não foi encontrado.");
        $extension = pathinfo($file, PATHINFO_EXTENSION);
    	if ($extension != "ini")
    	    throw new \Exception("Arquivo de configuração é inválido.");
		$this->fileContents = $this->parseFile($file);
	}

	/**
	* Convert array in object
	* @access private
	* @return obj Object converted 
	*/
	private function toObject($array){
	    if (is_array($array)){
	        $output = new \stdClass();
	        foreach ($array as $key => $value){
	            $output->$key = $this->toObject($value);
	        }
	    }else{
	        $output = $array;
	    }
	    return $output;
	}
	
	/**
	* Parse File .ini for the object
	* @access private
	* @return obj Object converted
	*/
	private function parseFile($file){
        return $this->toObject(parse_ini_file($file, true));
	}

	/**
	* Registry config em Registry
	* @access private
	* @return Void
	*/
	private function registryConfig(){
		foreach ($this->fileContents as $key => $val) {
			\Lemonade\Registry::Set($key, $val);
		}
	}

	/**
	* Registry config em Registry
	* @access private
	* @return Void
	*/
	private function registryCommandSql(){
		$adapter = "\Lemonade\Db\Adapter\\" . ucwords(\Lemonade\Registry::Get(\Lemonade\Config::NAME_DB_REGISTRY)->adapter);
        \Lemonade\Registry::Set("sql", $adapter::getSql());
	}

}