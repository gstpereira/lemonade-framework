<?php

/**
* Class for Model framework
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/

namespace Lemonade;

class Model extends \Lemonade\Db\Db{

	/**
	* name of table in database
	* @var string	
	*/
	static $table;

	/**
	* instance 
	* @access private
	* @var obj with command sql
	*/
	private static $sql = null;

	/**
	* primary key of database
	* @var string default = 'id'
	*/
	static $primary_key = "id";

	/**
	* Get instance with command sql
	* @access private
	* @return obj with command sql
	*/
	private static function sql(){
		if(is_null(self::$sql))
			self::$sql = \Lemonade\Registry::Get("sql");
		return self::$sql;
	}

	/**
	* save and update data in database
	* @access public
	* @param Array $data data for action in database
	* @return Void
	*/
	public static function save(Array $data){
		(array_key_exists(static::$primary_key, $data) || array_key_exists("where", $data)) ? self::update($data) : self::insert($data);
	}

	/**
	* insert data in database
	* @access private
	* @param Array $data data for action in database
	* @return Void
	*/
	private static function insert($data){
		$campos = implode(', ', array_keys($data));
		$camposPrepare = ":".implode(',:', array_keys($data));
		$values = array_combine(explode(",",$camposPrepare), array_values($data));
		$command = self::sql();
		$sql = self::prepare(sprintf($command->insert, static::$table, $campos, $camposPrepare));
		$sql->execute($values);
	}

	/**
	* update data in database
	* @access private
	* @param Array $data data for action in database
	* @return Void
	*/
	private static function update($data){
		$where = sprintf($command->where, array_key_exists("where", $data) ? $data["where"] : static::$primary_key."=".$data[static::$primary_key]);
		foreach ($data["fields"] as $ind => $val) {
			$fields[] = "{$ind} = :{$ind}";
			$indexPrepare[] = ":".$ind;
		}
		$fields = implode(",", $fields);
		$values = array_combine($indexPrepare, array_values($data));
		$command = self::sql();
		$sql = self::prepare(sprintf($command->update, static::$table, $fields, $where));
		$sql->execute($values);
	}

	/**
	* all data in database
	* @access public
	* @param Array $data data for filter search
	* @return Array
	*/
	public static function all(Array $data = null){
		$array = array("order_by","fields", "group_by");
		if(!is_null($data)){
			foreach ($data as $key => $val) {
				if(in_array($key, $array) && !empty($data[$key])){
					$right[$key] = $data[$key];
				}
			}
		}
		$right["where"] = 1;
		return self::find($right);
	}

	/**
	* find data in database
	* @access public
	* @para Array $data data for find
	* @return Obj
	*/
	public static function find(Array $data){
		$command = self::sql();
		$where = sprintf($command->where, array_key_exists("where", $data) ? $data["where"] : static::$primary_key."=".$data[static::$primary_key]);
		$order_by = array_key_exists("order_by", $data) ? sprintf($command->order_by, (substr($data["order_by"], 0, 1) == "-" ? substr($data["order_by"], 1)." DESC" : $data["order_by"]." ASC")) : "";
		$group_by = array_key_exists("group_by", $data) ? sprintf($command->group_by, (substr($data["group_by"], 0, 1) == "-" ? substr($data["group_by"], 1)." DESC" : $data["group_by"]." ASC")) : "";
		$limit = array_key_exists("limit", $data) ? sprintf($command->limit, $data["limit"]) : "";
		$offset = array_key_exists("offset", $data) ? sprintf($command->offset, $data["offset"]) : "";
		$fields = (isset($data["fields"]) && count($data["fields"])) ? implode(",", $data["fields"]) : "*";
		$result = self::prepare(sprintf($command->select, $fields, static::$table, $where, $group_by, $order_by, $limit, $offset));
		$result->setFetchMode(\PDO::FETCH_OBJ);
		$result->execute();
		$return = $result->fetchAll();
		return empty($return) ? null : $return;
	}

	/**
	* find by id data in database
	* @access public
	* @param Array/string $data Data for search, can be array with where or id
	* @return Obj
	*/
	public static function findById($data){
		if(is_array($data)){
			if(isset($data["fields"]) && !empty($data["fields"])){
				$right["fields"] = $data["fields"];
			}
			if(!isset($data[static::$primary_key]) || empty($data[static::$primary_key])) {
				throw new \Exception("Passe o " . static::$primary_key);
			}
			$right[static::$primary_key] = $data[static::$primary_key];
		}else{
			$right[static::$primary_key] = $data;
		}
		$return = self::find($right);
		return isset($return[0]) ? $return[0] : null;
	}

	/**
	* get one data in database
	* @access public
	* @param Array $data data for set fields and/or where
	* @return Obj
	*/
	public static function get($data){
		if(is_array($data)){
			if(isset($data["fields"]) && !empty($data["fields"])){
				$right["fields"] = $data["fields"];
			}
			if(isset($data["where"]) && !empty($data["where"])){
				$right["where"] = $data["where"];
			}else{
				throw new \Exception("Preencha o WHERE");
			}
		}else{
			$right[static::$primary_key] = $data;
		}
		$return = self::find($right);
		return isset($return[0]) ? $return[0] : null;
	}

	/**
	* delete data in database
	* @access public
	* @param Array $data where for delete
	* @return Void
	*/
	public static function delete(Array $data){
		$command = self::sql();
		$where = sprintf($command->where, array_key_exists("where", $data) ? $data["where"] : static::$primary_key."=".$data[static::$primary_key]);
		$result = self::prepare(sprintf($command->delete, static::$table, $where));
		$result->execute();
	}

	/**
	* delete all data in database
	* @access public
	* @return Void
	*/
	public static function deleteAll(){
		self::delete(array("where" => 1));
	}

	/**
	* first data in database
	* @access public
	* @param Array $data data for filter search
	* @return Obj
	*/
	public static function first(Array $data = null){
		$data = is_null($data) ? array() : $data;
		$return = self::commonFirstLast($data);
		$return["order_by"] = $return["column"];
		$search = self::find($return);
		return isset($search[0]) ? $search[0] : null;
	}

	/**
	* last data in database
	* @access public
	* @param Array $data data for filter search
	* @return Obj
	*/
	public static function last(Array $data = null){
		$data = is_null($data) ? array() : $data;
		$return = self::commonFirstLast($data);
		$return["order_by"] = "-".$return["column"];
		$search = self::find($return);
		return isset($search[0]) ? $search[0] : null;
	}

	/**
	* Common action for metho first and last
	* @access public
	* @param Array $data data for filter search
	* @return Array
	*/
	private static function commonFirstLast(Array $data){
		if(isset($data["fields"]) && !empty($data["fields"])){
			$right["fields"] = $data["fields"];
		}
		if(isset($data["column"]) && !empty($data["column"])){
			$right["column"] = $data["column"];
		}else{
			$right["column"] = static::$primary_key;
		}
		$right["where"] = 1;
		$right["limit"] = 1;
		return $right;
	}

}