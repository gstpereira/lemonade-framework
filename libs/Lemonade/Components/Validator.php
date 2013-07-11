<?php
/**
* Validator System
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/
namespace Lemonade\Components;

class Validator{
	
	/**
	* Instance of Validator
	* @access private
	* @var \Lemonade\Components\Core\Validator
	*/
	private $instance;

	/**
	* Construct
    * @access public
    * @return Void
	*/
	public function __construct(){
		$this->instance = new \Lemonade\Components\Core\Validator();
	}

	/**
	* Set a data validator
	* @access public
	* @param String $name name of validator
	* @param Mixed $value value of validator
	* @return \Lemonade\Components\Validator
	*/
	public function set($name, $value){
		$this->instance->set($name, $value);
		return $this;
	}

	/**
	* The number of validators methods available in DataValidator
	* @access public
	* @return \Lemonade\Components\Validator
	*/
    public function get_number_validators_methods(){
        return count($this->_messages);
    }
    
    /**
    * Define a custom error message for some method
    * @access public
    * @param String $name The name of the method
    * @param String $value The custom message
    * @return null
    */
    public function setMessage($name, $value){
        $this->instance->set_message($name, $value);
    }
    
    
    /**
    * Get the error messages
    * @access public
    * @param String $param [optional] A specific method
    * @return String
    */
    public function getMessages($param = false){
        return $this->instance->get_messages($param);
    }
    
    
    /**
    * Define the pattern of name of error messages
    * @access public
    * @param String $prefix [optional] The prefix of name
    * @param String $sufix [optional] The sufix of name
    * @return null
    */
    public function definePattern($prefix = '', $sufix = ''){
        $this->instance->define_pattern($prefix, $sufix);
    }
    
    /**
    * Verify if the current data is not null
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isRequired(){
        $this->instance->is_required();
        return $this;
    } 
    
    
    /**
    * Verify if the length of current value is less than the parameter
    * @access public
    * @param Int $length The value for compare
    * @param Boolean $inclusive [optional] Include the lenght in the comparison
    * @return \Lemonade\Components\Validator
    */
    public function minLength($length, $inclusive = false){
        $this->instance->min_length($length, $inclusive);
        return $this;
    }
    
    
    /**
    * Verify if the length of current value is more than the parameter
    * @access public
    * @param Int $length The value for compare
    * @param Boolean $inclusive [optional] Include the lenght in the comparison
    * @return \Lemonade\Components\Validator
    */
    public function maxLength($length, $inclusive = false){
        $this->instance->max_length($length, $inclusive);
        return $this;
    }
    
    
    /**
    * Verify if the length current value is between than the parameters
    * @access public
    * @param Int $min The minimum value for compare
    * @param Int $max The maximum value for compare
    * @return \Lemonade\Components\Validator
    */
    public function betweenLength($min, $max){
        $this->instance->between_length($min, $max);
        return $this;
    }
    
    
    /**
    * Verify if the current value is less than the parameter
    * @access public
    * @param Int $value The value for compare
    * @param Boolean $inclusive [optional] Include the value in the comparison
    * @return \Lemonade\Components\Validator
    */
    public function minValue($value, $inclusive = false){
        $this->instance->min_value($value, $inclusive);
        return $this;
    }
    
    
    /**
    * Verify if the current value is more than the parameter
    * @access public
    * @param Int $value The value for compare
    * @param Boolean $inclusive [optional] Include the value in the comparison
    * @return \Lemonade\Components\Validator
    */
    public function maxValue($value, $inclusive = false){
        $this->instance->max_value($value, $inclusive);
        return $this;
    }
    
    
    /**
    * Verify if the length of current value is more than the parameter
    * @access public
    * @param Int $min_value The minimum value for compare
    * @param Int $max_value The maximum value for compare
    * @return \Lemonade\Components\Validator
    */
    public function betweenValues($min_value, $max_value){
        $this->instance->between_values($min_value, $max_value);
        return $this;
    }
    
    
    /**
    * Verify if the current data is a valid email
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isEmail(){
        $this->instance->is_email();
        return $this;
    }
    
    
    /**
    * Verify if the current data is a valid URL
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isUrl(){
        $this->instance->is_url();
        return $this;
    }
    
    
    /**
    * Verify if the current data is a slug
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isSlug(){
        $this->instance->is_slug();
        return $this;        
    }
    
    
    /**
    * Verify if the current data is a numeric value
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isNum(){
        $this->instance->is_num();
        return $this;
    }
    
    
    /**
    * Verify if the current data is a integer value
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isInteger(){
        $this->instance->is_integer();
        return $this;
    }
    
    
    /**
    * Verify if the current data is a float value
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isFloat(){
        $this->instance->is_float();
        return $this;
    }
    
    
    /**
    * Verify if the current data is a string value
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isString(){
        $this->instance->is_string();
        return $this;
    }
    
    
    /**
    * Verify if the current data is a boolean value
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isBoolean(){
        $this->instance->is_boolean();
        return $this;
    }
    
    
    /**
    * Verify if the current data is a object
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isObj(){
        $this->instance->is_obj();
        return $this;
    }
    
    
    /**
    * Verify if the current data is a instance of the determinate class
    * @access public
    * @param String $class The class for compare
    * @return \Lemonade\Components\Validator
    */
    public function isInstanceOf($class){
        $this->instance->is_instance_of($class);
        return $this;
    }
    
    
    /**
    * Verify if the current data is a array
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isArr(){
        $this->instance->is_arr();
        return $this;
    }
    
    
    /**
    * Verify if the current parameter it is a directory
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isDir(){
        $this->instance->is_directory();
        return $this;
    }
    
    
    /**
    * Verify if the current data is equals than the parameter
    * @access public
    * @param String $value The value for compare
    * @param Boolean $identical [optional] Identical?
    * @return \Lemonade\Components\Validator
    */
    public function isEquals($value, $identical = false){
        $this->instance->is_equals($value, $identical);
        return $this;
    }
    
    
    /**
    * Verify if the current data is not equals than the parameter
    * @access public
    * @param String $value The value for compare
    * @param Boolean $identical [optional] Identical?
    * @return \Lemonade\Components\Validator
    */
    public function isNotEquals($value, $identical = false){
        $this->instance->is_not_equals($value, $identical);
        return $this;
    }
    
    
    /**
    * Verify if the current data is a valid CPF
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isCpf(){
        $this->instance->is_cpf();
        return $this;
    }
    
    
    /**
    * Verify if the current data is a valid CNPJ
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isCnpj(){
        $this->instance->is_cnpj();
        return $this;
    }
    
    
    /**
    * Verify if the current data contains in the parameter
    * @access public
    * @param Mixed $values One array or String with valids values
    * @param Mixed $separator [optional] If $values as a String, pass the separator of values (ex: , - | )
    * @return \Lemonade\Components\Validator
    */
    public function contains($values, $separator = false){
        $this->instance->contains($values, $separator);
        return $this;
    }
    
    
    /**
    * Verify if the current data not contains in the parameter
    * @access public
    * @param Mixed $values One array or String with valids values
    * @param Mixed $separator [optional] If $values as a String, pass the separator of values (ex: , - | )
    * @return \Lemonade\Components\Validator
    */
    public function notContains($values, $separator = false){
        $this->instance->not_contains($values, $separator);
        return $this;
    }
    
    
    /**
    * Verify if the current data is loweracase
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isLower(){
        $this->instance->is_lowercase();
        return $this;
    }
    
    
    /**
    * Verify if the current data is uppercase
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function isUpper(){
       $this->instance->is_uppercase();
        return $this;
    }
    
    
    /**
    * Verify if the current data is multiple of the parameter
    * @access public
    * @param Int $value The value for comparison
    * @return \Lemonade\Components\Validator
    */
    public function isMultiple($value){
        $this->instance->is_multiple($value);
        return $this;
    }
    
    
    /**
    * Verify if the current data is a positive number
    * @access public
    * @param Boolean $inclusive [optional] Include 0 in comparison?
    * @return \Lemonade\Components\Validator
    */
    public function isPositive($inclusive = false){
        $this->instance->is_positive($inclusive);
        return $this;
    }
    
    
    /**
    * Verify if the current data is a negative number
    * @access public
    * @param Boolean $inclusive [optional] Include 0 in comparison?
    * @return \Lemonade\Components\Validator
    */
    public function isNegative($inclusive = false){
        $this->instance->is_negative($inclusive);
        return $this;
    }
    
    
    /**
    * Verify if the current data is a valid Date
    * @access public
    * @param String $format [optional] The Date format
    * @return \Lemonade\Components\Validator
    */
    public function isDate($format = null){
        $this->instance->is_date($format);
        return $this;
    }
    
    /**
    * Verify if the current data contains just alpha caracters
    * @access public
    * @param String $additional [optional] The extra caracters
    * @return \Lemonade\Components\Validator
    */
    public function isAlpha($additional = ''){
        $this->instance->is_alpha($additional);
        return $this;
    }
    
    
    /**
    * Verify if the current data contains just alpha-numerics caracters
    * @access public
    * @param String $additional [optional] The extra caracters
    * @return \Lemonade\Components\Validator
    */
    public function isAlphaNum($additional = ''){
        $this->instance->is_alpha_num($additional);
        return $this;
    }
    
    
    /**
    * Verify if the current data no contains white spaces
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function noWhitespaces(){
        $this->instance->no_whitespaces();
        return $this;
    }
    
    
    /**
    * Validate the data
    * @access public
    * @return \Lemonade\Components\Validator
    */
    public function validate(){
        return $this->instance->validate();
    }
    
    
    /**
    * The messages of invalid data
    * @param String $param [optional] A specific error
    * @return \Lemonade\Components\Validator
    */
    public function getErrors($param = false){
        return $this->instance->get_errors($param);
    }

}