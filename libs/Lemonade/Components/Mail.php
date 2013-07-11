<?php
/**
* Mail System
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/

namespace Lemonade\Components;

class Mail{

	/**
	 * Configuration of email
	 * @access private
	 * @var obj
	 */
	private $config;

	/**
	 * Instance of PHPMailer
	 * @access private
	 * @var PHPMailer
	 */
	private $instance;

	/**
	 * Construct
	 * @access public
	 * @return Void
	 */
	public function __construct(){
		require_once("Core/Mail/class.phpmailer.php");
		$this->instance = new \PHPMailer();
		$this->config = \Lemonade\Registry::Get("mail");
		$this->instance->Host = $this->config->host;
		$this->instance->Port = $this->config->port;
		$this->instance->Username = $this->config->host_user;
		$this->instance->Password = $this->config->host_password;
		$this->instance->SMTPAuth = ($this->config->authenticate == "true") ? true : false;
		$this->instance->IsSMTP();
		$this->instance->From = $this->config->mail_from;
		$this->instance->FromName = $this->config->name_from;
	}

	/**
	 * Set e-mails anddress for send
	 * @access public
	 * @param Array $address e-mails
	 * @return Vois
	 */
	public function setAddress(Array $address){
		$validate = new \Lemonade\Components\Validator();
		foreach ($address as $name => $add) {
			if(!is_numeric($name)){
				$this->instance->AddAddress($add, $name);
			}else{
				$this->instance->AddAddress($add);
			}
		}
	}

	/**
	 * Send e-mails
	 * @access public
	 * @param  String  $message Message for send
	 * @param  string  $subject subject for e-mail
	 * @param  boolean $isHtml  confirm if message is text HTML
	 * @return bool           true or false send
	 */
	public function send($message, $subject = "", $isHtml = false){
		$this->instance->IsHTML($isHtml);
		$subject = (isset($this->config->subject_prefix)) ? $this->config->subject_prefix . ((!empty($subject)) ? " - " . $subject : "") : $subject ;
		$this->instance->Subject = $subject;
		$this->instance->Body = $message;
		$this->instance->AltBody = strip_tags($message);
		$send = $this->instance->Send();
		$this->instance->ClearAllRecipients();
		$this->instance->ClearAttachments();
		return $send;
	}

}