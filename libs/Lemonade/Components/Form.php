<?php
/**
* Form System
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/

namespace Lemonade\Components;

class Form{

	/**
	 * Fields for create form
	 * @var Array
	 */
	static $fields;

	/**
	 * type display form in view
	 * @var string
	 */
	static $display = "li";

	/**
	 * Fields fill for validate
	 * @access private
	 * @var Array
	 */
	private $fillFields;

	/**
	 * if validate with post
	 * @access private
	 * @var boolean
	 */
	private $validate = true;

	/**
	 * Errors with validate
	 * @access private
	 * @var array
	 */
	private $errors = array();

	/**
	 * type the validate
	 * @access private
	 * @var array
	 */
	private $typeValidate = array(
			"required" => "isRequired",
			"email" => "isEmail",
			"url" => "isUrl",
			"num" => "isNum",
			"integer" => "isInteger",
			"float" => "isFloat",
			"string" => "isString",
			"date" => "isDate",
			"positive" => "isPositive",
			"negative" => "isNegative",
		);

	/**
	 * Construct
	 * @access public
	 * @param Array/null $form form for validate
	 * @return Void
	 */				
	public function __construct($form = null){
		if(is_null($form)){
			$this->fillFields();
		}else{
			$this->fill($form);
		}
	}

	/**
	 * Fill form for validete
	 * @access private
	 * @param  Array  $form form fill
	 * @return Void
	 */
	private function fill(Array $form){
		foreach ($form as $key => $val) {
			if(array_key_exists($key, static::$fields)){
				$validateAuthomatic = array("url", "num", "email", "date");
				if(array_key_exists("validate", static::$fields[$key])){
					if(in_array(static::$fields[$key]["type"], $validateAuthomatic)){
						if(!in_array(static::$fields[$key]["type"], static::$fields[$key]["validate"])){
							static::$fields[$key]["validate"] = array(static::$fields[$key]["type"]);
						}
					}
					$this->formValidate($key, $val);
				}else if(in_array(static::$fields[$key]["type"], $validateAuthomatic)){
					static::$fields[$key]["validate"] = array(static::$fields[$key]["type"]);
					$this->formValidate($key, $val);
				}
			}
		}
	}

	/**
	 * Validate form
	 * @access private
	 * @param  string $name  name of validate
	 * @param  string $value value fo calidate
	 * @return Void
	 */
	private function formValidate($name, $value){
		$objValidate = new \Lemonade\Components\Validator();
		$field = $objValidate->set($name, $value);
		foreach (static::$fields[$name]["validate"] as $validate){
			$attrValidate = $this->typeValidate[$validate];
			$field->$attrValidate();
		}
		if(!$field->validate()){
			$this->validate = false;
			foreach ($field->getErrors() as $name => $errors) {
				$erro[$name] = $errors;
			}
		}
		if(!$this->validate){
			$this->errors = $erro;
		}
		$this->fillFields();
	}

	/**
	 * Create fields
	 * @access private
	 * @return Void
	 */
	private function fillFields(){
		$this->fillFields = "";
		foreach (static::$fields as $key => $val) {
			$this->fillFields .= "<" . static::$display . ">" . $this->fillInput($key, $val) . "</" . static::$display . ">";
		}
	}

	/**
	 * Fill data in fields
	 * @acess private
	 * @param  string $name name of field
	 * @param  Array  $data data for fields
	 * @return string       field
	 */
	private function fillInput($name, Array $data){
		if($data["type"] != "select" && $data["type"] != "textarea"){
			$input = "<input type='" . $data["type"] . "' name='" . $name . "' "; 
		}else{
			$input = "<" . $data["type"] . " name='" . $name . "' "; 
		}
		if(isset($data["option"]) && !empty($data["option"])){
			$input .= $this->fillOption($name, $data);
		}
		if(isset($data["value"]) && !empty($data["value"])){
			$input .= $this->fillValue($data);
		}
		if($data["type"] != "select" && $data["type"] != "textarea"){
			$input .= "/>";
		}else{
			if(!isset($data["value"])){
				$input .= ">";
			}
			$input .= "</" . $data["type"] . ">";
		}
		echo htmlentities($input);
		exit();
		return $input;
	}

	/**
	 * Option the field
	 * @access private
	 * @param  string $name name of field
	 * @param  Array  $data data for option
	 * @return strign       field
	 */
	private function fillOption($name, Array $data){
		$input = "";
		$input .= (isset($data["option"]["id"]) && !empty($data["option"]["id"])) ? "id='" . $data["option"]["id"] . "' " : "id='id_" . $name . "' ";
		$input .= (isset($data["option"]["class"]) && !empty($data["option"]["class"])) ? "class='" . $data["option"]["class"] . "' " : "" ;
		$input .= (in_array("disabled", $data["option"])) ? "disabled " : "" ;
		$input .= (in_array("checked", $data["option"]) && ($data["type"] == "checkbox" || $data["type"] == "radio")) ? "checked " : "" ;
		return $input;
	}

	/**
	 * Fill value of field
	 * @access private
	 * @param  Array  $data data for value and option case type is select
	 * @return string       field
	 */
	private function fillValue(Array $data){
		$input = "";
		if($data["type"] == "textarea" || $data["type"] == "select"){
			$input .= ">";
			if(is_array($data["value"]) && $data["type"] == "select"){
				foreach ($data["value"] as $key => $val) {
					$input .= "<option value='" . $key . "'>" . $val . "</option>";
				}
			}
		}
		if($data["type"] != "select"){
			$input .= ($data["type"] == "textarea") ? $data["value"] : "value='" . $data["value"] . "' ";
		}
		return $input;
	}

	/**
	 * valid form
	 * @return boolean if is valid
	 */
	public function isValid(){
		return $this->validate;
	}

	/**
	 * Get Errors for validate
	 * @return Array errors
	 */
	public function getErrors(){
		return $this->errors;
	}

	/**
	 * Method for print in view
	 * @return string fields
	 */
	public function __toString(){
		return $this->fillFields;
	}

}

 