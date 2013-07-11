<?php
/**
* Paginator System
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/

namespace Lemonade\Components;

class Paginator{
	
	/**
	* model for pagination
	* @access private
	* @var string
	*/
	private $model;

	/**
	* length data for return
	* @access private
	* @var int
	*/
	private $length;

	/**
	* data for return in pagination
	* @access prviate
	* @var string
	*/
	private $data = array();

	/**
	* Set config Paginator
	* @access public
	* @param $model string Model for pagination
	* @param $length int number of data for return
	* @param $data array data for pagination(fields,order_by)
	* @return Obj this
	*/
	public function set($model, $length, Array $data = null){
		$this->model = $model;
		$this->length = $length;
		$array = array("order_by","fields");
		if(!is_null($data)){
			foreach ($data as $key => $val) {
				if(in_array($key, $array) && !empty($data[$key])){
					$this->data[$key] = $data[$key];
				}
			}
		}
		$this->data["where"] = isset($data["where"]) ? $data["where"] : 1;
		return $this;
	}

	/**
	* Get data of paginator
	* @access public
	* @return Array data of paginator
	*/
	public function get($page = 0){
		$this->data["limit"] = ($page * $this->length) . "," . $this->length;
		return call_user_func($this->model . "::find", $this->data);
	}

}