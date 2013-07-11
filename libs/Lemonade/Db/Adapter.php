<?php

/**
* Class Abstract for Adapter
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/
namespace Lemonade\Db;

class Adapter{

    /**
    * Construct private for not instance this class
    * @access private
    * @return Void
    */
    private function __construct(){}
    
    /**
    * return connection with database
    * @access public
    * @return \Lemonade\Db\Adapter
    */
    public static function factory(){
        $db = \Lemonade\Registry::Get(\Lemonade\Config::NAME_DB_REGISTRY);
        switch ($db->adapter) {
            case "mysql":
                \Lemonade\Registry::Set("sql", \Lemonade\Db\Adapter\Mysql::getSql());
                return \Lemonade\Db\Adapter\Mysql::getConnection($db);
                break;
            default:
                throw new \Exception("Adaptador não suportado.");
                break;
        }
    }
}