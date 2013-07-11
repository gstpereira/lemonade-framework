<?php
/**
* Error Treatment System
* @author Gustavo Henrique
* @link http://gustavohenriq.com
*/

namespace Lemonade;

class Erro{

	/**
	 * Method for error treatment 
	 * @access public
	 * @param  string $errno   error number
	 * @param  string $errstr  error description
	 * @param  string $errfile error with file
	 * @param  string $errline error line
	 * @return Void   
	 */
	public function treatmentError($errno, $errstr='', $errfile='', $errline=''){
		$errorType = array (
			E_ERROR => 'ERROR',
			E_WARNING => 'WARNING',
			E_PARSE => 'PARSING ERROR',
			E_NOTICE => 'NOTICE',
			E_CORE_ERROR => 'CORE ERROR',
			E_CORE_WARNING => 'CORE WARNING',
			E_COMPILE_ERROR => 'COMPILE ERROR',
			E_COMPILE_WARNING => 'COMPILE WARNING',
			E_USER_ERROR => 'USER ERROR',
			E_USER_WARNING => 'USER WARNING',
			E_USER_NOTICE => 'USER NOTICE',
			E_STRICT => 'STRICT NOTICE',
			E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR',
			E_DEPRECATED => 'DEPRECATED',
		);

		$err = $errorType[$errno];

		if (ini_get('log_errors')){
        	error_log(sprintf("PHP %s:  %s in %s on line %d", $err, $errstr, $errfile, $errline));
        }

		if(\Lemonade\Registry::Get("config")->debug == "false"){
	        $mensagem = '';
			$mensagem .= '[ ERRO NO PHP ]' . "<br />";
			$mensagem .= 'Site: ' . \Lemonade\Registry::Get("mail")->site . "<br />";
			$mensagem .= 'Tipo de erro: ' . $err . "<br />";
			$mensagem .= 'Arquivo: ' . $errfile . "<br />";
			$mensagem .= 'Linha: ' . $errline . "<br />";
			$mensagem .= 'Descrição: ' . $errstr . "<br />";
			if (isset($_SERVER['REMOTE_ADDR'])) {
				$mensagem .= "<br />";
				$mensagem .= '[ DADOS DO VISITANTE ]' . "<br />";
				$mensagem .= 'IP: ' . $_SERVER['REMOTE_ADDR'] . "<br />";
				$mensagem .= 'User Agent: ' . $_SERVER['HTTP_USER_AGENT'] . "<br />";
			}
			if (isset($_SERVER['REQUEST_URI'])) {
				$url = (preg_match('/HTTPS/i', $_SERVER["SERVER_PROTOCOL"])) ? 'https' : 'http';
				$url .= '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				$mensagem .= "<br />";
				$mensagem .= 'URL: ' . $url . "<br />";
			}
			if (isset($_SERVER['HTTP_REFERER'])) {
				$mensagem .= 'Referer: ' . $_SERVER['HTTP_REFERER'] . "<br />";
			}
			$mensagem .= "<br />";
			$mensagem .= 'Data: ' . date('d/m/Y H:i:s'). "<br />";
			$assunto = '[' . $err . '] ' . \Lemonade\Registry::Get("mail")->site . ' - ' . date('d/m/y H:i:s');
			$mail = new \Lemonade\Components\Mail();
			$mail->setAddress(array(\Lemonade\Registry::Get("mail")->admin_email));
			$mail->send($mensagem, $assunto, true);
			echo "Ocorreu um erro";
		}else{
			echo '<b>' . $err . ':</b> ' . $errstr . ' no arquivo ' . $errfile . ' (Linha ' . $errline . ')<br />';
		}
	}

	/**
	 * Method for exception treatment 
	 * @param  Mixed $exception exception
	 * @return Void
	 */
	public function treatmentException($exception){
		echo $exception->getMessage();
	}

}