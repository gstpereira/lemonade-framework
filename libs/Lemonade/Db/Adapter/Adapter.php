<?php

/**
* Class adapter for database
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/
namespace Lemonade\Db\Adapter;

abstract class Adapter{

	/**
	* @var PDO instance connection with database
    * @access protected
	*/
    protected static $connection;
    
    /**
	* Get Connection with database - Singleton
    * @access public
    * @return instance PDO
    */
    public static function getConnection($db_config){
        if (empty(self::$connection)){
            $dsn = "{$db_config->adapter}:host={$db_config->host};dbname={$db_config->database}";
            try{
                self::$connection = new \PDO($dsn, $db_config->user, $db_config->password);
            }catch (\Exception $e) {
                throw new \Exception("Verifique as configurações de conexão com o banco");
            }
        }
        return self::$connection;
    }

    /**
    * Get text sql
    * @access public
    * @return Array sqls texts
    */
    public static function getSql(){
        $sql = new \stdClass();
        $sql->select = "SELECT %s FROM %s %s %s %s %s %s";
        $sql->delete = "DELETE FROM %s %s";
        $sql->update = "UPDATE %s SET %s %s";
        $sql->insert = "INSERT INTO %s (%s) VALUES (%s)";
        $sql->group_by = "GROUP BY %s";
        $sql->order_by = "ORDER BY %s";
        $sql->limit = "LIMIT %s";
        $sql->offset = "OFFSET %s";
        $sql->where = "WHERE %s";
        return $sql;
    }
}