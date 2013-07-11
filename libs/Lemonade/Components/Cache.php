<?php
/**
* Cache System
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/

namespace Lemonade\Components;

class Cache{

	/**
	 * Time the cache
	 * @access private
	 * @var int
	 */
	private $time = 60;	

	/**
	 * Get folder for cache
	 * @access private
	 * @return String folder for cache
	 */
	private function getFolder(){
		return (isset(\Lemonade\Registry::Get("config")->cache_folder)) ? \Lemonade\Lemonade::getAppDir() . "cache" . DIRECTORY_SEPARATOR . \Lemonade\Registry::Get("config")->cache_folder : sys_get_temp_dir();
	}

	/**
	 * Get file location
	 * @access private
	 * @param  String $key name of cache key 
	 * @return String      flie location
	 */
	private function getFileLocation($key){
		return $this->getFolder() . DIRECTORY_SEPARATOR . sha1($key) . ".tmp";
	}

	/**
	 * Create file of cache
	 * @access private
	 * @param  String $key   name of cache key
	 * @param  String $value value of cache
	 * @return bool        if create file
	 */
	private function createFile($key, $value){
		return file_put_contents($this->getFileLocation($key), $value);
	}

	/**
	 * Set data and create cache file
	 * @access public
	 * @param String $key   name of cache key
	 * @param String $value value of cache
	 * @param int $time  time of cache
	 * @return bool if create file
	 */
	public function set($key, $value, $time = null){
		$time = strtotime((!is_null($time) ? $time : $this->time) . " seconds");
		$value = serialize(array("expires" => $time, "content" => $value));
		return $this->createFile($key, $value);
	}

	/**
	 * Get cahce value 
	 * @param  Strnig $key name of cache key
	 * @return Mixed      Value or null and remove file
	 */
	public function get($key){
		$file = $this->getFileLocation($key);
		if(file_exists($file) && is_readable($file)){
			$fileCache = unserialize(file_get_contents($file));
			if($fileCache["expires"] > time()){
				return $fileCache["content"];
			}else{
				unlink($file);
			}
		}
		return null;
	}

	
}