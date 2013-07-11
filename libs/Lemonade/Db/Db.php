<?php

namespace Lemonade\Db;

abstract class Db{

    /**
    * Get Connection wiht database
    * @access protected
    * @return mixed
    */
    protected static function getDbConnection(){
        return \Lemonade\Db\Adapter::factory();
    }

    /**
    * Override method PDO
    * @access public
    * @return mixed
    */
    public static function beginTransaction(){
        return self::getDbConnection()->beginTransaction();
    }
    
    /**
    * Override method PDO
    * @access public
    * @return mixed
    */
    public static function commit(){
        return self::getDbConnection()->commit();
    }
    
    /**
    * Override method PDO
    * @access public
    * @return mixed
    */
    public static function errorCode(){
        return self::getDbConnection()->errorCode();
    }
    
    /**
    * Override method PDO
    * @access public
    * @return mixed
    */
    public static function errorInfo(){
        return self::getDbConnection()->errorInfo();
    }
    
    /**
    * Override method PDO
    * @access public
    * @return mixed
    */    
    public static function exec($statement){
        return self::getDbConnection()->exec($statement);
    }
    
    /**
    * Override method PDO
    * @access public
    * @return mixed
    */
    public static function getAttribute($attribute){
        return self::getDbConnection()->getAttribute($attribute);
    }
    
    /**
    * Override method PDO
    * @access public
    * @return mixed
    */
    public static function getAvailableDrivers(){
        return self::getDbConnection()->getAvailableDrivers();
    }
    
    /**
    * Override method PDO
    * @access public
    * @return mixed
    */
    public static function inTransaction(){
        return self::getDbConnection()->inTransaction();
    }
    
    /**
    * Override method PDO
    * @access public
    * @return mixed
    */
    public static function lastInsertId($name = null){
        return self::getDbConnection()->lastInsertId($name);
    }
    
    /**
    * Override method PDO
    * @access public
    * @return mixed
    */
    public static function prepare($statement, $driver_options = array()){
        return self::getDbConnection()->prepare($statement, $driver_options);
    }
    
    /**
    * Override method PDO
    * @access public
    * @return mixed
    */
    public static function query($statement){
        return self::getDbConnection()->query($statement);
    }
    
    /**
    * Override method PDO
    * @access public
    * @return mixed
    */
    public static function quote($string, $parameter_type = PDO::PARAM_STR){
        return self::getDbConnection()->quote($string, $parameter_type);
    }
    
    /**
    * Override method PDO
    * @access public
    * @return mixed
    */
    public static function rollBack(){
        return self::getDbConnection()->rollBack();
    }
    
    /**
    * Override method PDO
    * @access public
    * @return mixed
    */
    public static function setAttribute($attribute, $value){
        return self::getDbConnection()->setAttribute($attribute, $value);
    }
}