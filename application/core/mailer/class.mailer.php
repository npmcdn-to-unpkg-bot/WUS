<?php

include("class.phpmailer.php");
include("class.smtp.php"); 

class Mailer {

	private $mail = null;
	public $from;
	public $fromName;
	public $to;
	public $toName;
	public $subject;
	public $content;
	public $contentName;
	public $debug;
	
	public function __construct() {
		
		$this->mail = new PHPMailer();

		//set default server configuration
		$this->serverConfig();

		//set default sender configuration
		$this->defaultInformations();

		//set utf8 encoding by default
		$this->mail->CharSet = "UTF-8";

	}


	public function confirmTo($email) {

		$this->mail->ConfirmReadingTo = $email;
	}

	public function attach($file) {

		$this->mail->AddAttachment($file);
	}

	public function cc($email, $name = "") {

		$this->mail->AddCC($email, $name);
	}

	public function cci($email, $name = "") {

		$this->mail->AddBCC($email, $name);
	}

	public function send() {

		//from
		$this->mail->From       = $this->from;
		$this->mail->FromName   = $this->fromName;

		//to
		$this->mail->AddAddress($this->to, $this->toName);

		//subject
		$this->mail->Subject    = $this->subject;

		//body
		$this->mail->AltBody    = $this->contentName;
		$this->mail->Body   	= $this->content;

		if(!$this->mail->Send()) {
			error_log("Mailer Error: " . $this->mail->ErrorInfo);
		} else {
			if($this->debug)
		  		error_log("Email envoyé avec succés");
		}
	}

	private function serverConfig() {

		$this->mail->IsSMTP();

		//server config
		$this->mail->SMTPAuth   = true;                           
		$this->mail->Host       = "mail.gandi.net";     
		$this->mail->Port       = 25; 

		//smtp account config
		$this->mail->Username   = "hamza.guitouni@ilopro.com";
		$this->mail->Password   = "sos1sos2"; 

		//security config
		// $this->mail->SMTPSecure = "ssl";
	}

	public function defaultInformations() {

		$this->from     = "contact@ilopro.com";
		$this->fromName = "ILOPRO";
		$this->subject  = "Email de la societe Ilopro";
		$this->altBody  = "Ilopro.com";
		$this->body 	= '';

		$this->debug 	= false;

	}

	public function isHTML() {
		$this->mail->isHTML(true);
	}

}

?>