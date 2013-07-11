<?php

/**
* Class for Registry framework
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/
namespace Lemonade;

class Registry{

    /**
    * @var array
    * @access protected
    */
    protected static $registers = array();
    
    /**
    * Set data for registry
    * @access public
    * @param string index for registry
    * @param something value for registry
    * @return Void
    */
    public static function Set($registry_name, $registry_value){
        self::$registers[$registry_name] = $registry_value;
    }
    
    /**
    * Get data for registry
    * @access public
    * @param string index the registry
    * @return Array Register with index
    */
    public static function Get($registry_name){
        if ( !isset(self::$registers[$registry_name]) ){
            throw new \Exception("Defina {$registry_name} no arquivo de configuração.");
        }
        return self::$registers[$registry_name];
    }
}