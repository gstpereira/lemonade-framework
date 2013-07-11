<?php
/**
* Upload System
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/
namespace Lemonade\Components;

class Upload{
	
	/**
	* Instance of Upload
	* @access private
	* @var \Lemonade\Components\Core\Upload
	*/
	private $instance;

	/**
	* Construct
	* @access public
	* @return Void
	*/
	public function __construct(){
		$this->instance = new \Lemonade\Components\Core\Upload();
	}

	/**
	* Set basic config
	* @access public
	* @param $file File The file to be upload
    * @param $folder String The path of the receive folder
    * @param $fileName String The new name
    * @param $language String language for errors
    * @return Void
	*/
	public function set($file = '', $folder = '', $fileName = '', $encrypt = '', $language = ''){
		if (!empty ($file)){
            $this->instance->set_file($file);
        }        
        if (!empty ($folder)){
            $this->instance->set_uploads_folder($folder);
        }        
        if (!empty ($encrypt)){
            $this->instance->set_encrypt($encrypt);
        }
        if (!empty ($fileName)){
            $this->instance->set_file_name($fileName);
        }
        if (!empty ($language)){
            $this->instance->set_language($setLanguage());
        }
	}

	/**
    * Set the language messages
    * @access public
    * @param $language String The language
    * @return \Lemonade\Components\Upload
    */
    public function setLanguage($language){
        $this->instance->set_language($language);
        return $this;
    }
    
    /**
     * Set the encrypt of file name
     * @access public
     * @param $type String the encrypt for name of file
     * @return \Lemonade\Components\Upload
     */
    public function setEncrypt($type){
        $this->instance->set_encrypt($type);
        return $this;
    }

    /**
    * Set a file
    * @access public
    * @param $file File The file to be upload
    * @return \Lemonade\Components\Upload
    */
    public function setFile($file){
        $this->instance->set_file($file);
        return $this;
    }

    /**
    * Set the folder to receive the file
    * @access public
    * @param $folder String The path of the receive folder
    * @return \Lemonade\Components\Upload
    */
    public function setFolder($folder){
        $this->instance->set_uploads_folder($folder);
        return $this;
    }
    
    
    /**
    * Set the new name of the file
    * @access public
    * @param $name String The new name
    * @return \Lemonade\Components\Upload
    */
    public function setFileName($name){
        $this->instance->set_file_name($name);
        return $this;
    }
    
    
    /**
    * Set the max size of file
    * @access public
    * @param $size Double The max size of file
    * @return \Lemonade\Components\Upload
    */
    public function setMaxSize($size){
        $this->instance->set_max_size($size);
        return $this;
    }
    
    
    /**
    * Set the allowed extensions in the upload
    * @access public
    * @param $exts String The new name
    * @return \Lemonade\Components\Upload
    */
    public function setAllowedExts($exts){
       $this->instance->set_allowed_exts($exts);
       return $this;
    }
    
    
    /**
    * Overwrite file with same name? (true or false)
    * @access public
    * @param $param Boolean Yes(true) or No(false)
    * @return \Lemonade\Components\Upload
    */
    public function setOverwrite($param){
        $this->instance->set_overwrite($param);
        return $this;
    }

	/**
    * Get the error message
    * @access public
    * @return String The error message
    */
    public function getError(){
        return $this->instance->get_error();
    }

	/**
    * Get the uploaded file path
    * @access public
    * @return String The uploaded file path
    */
    public function getFilePath(){
        return $this->instance->get_file_path();
    }

	/**
    * Upload the file
    * @access public
    * @return Boolean True if file has been uploaded
    */
    public function upload(){
        return $this->instance->upload_file();
    }

}