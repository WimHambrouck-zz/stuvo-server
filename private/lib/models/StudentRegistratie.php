<?php namespace mvdwcms\models;
/**
 * MVdW Content Management System
 *
 * @project MVdW CMS
 * @version 2014
 * @author Maxim Van de Wynckel
 */
 
include_once (dirname(dirname(dirname(__FILE__))).'/include.php');


 class StudentRegistratie{
	private $id = -1;
	private $email = "";
	private $privatekey = "";
	private $received = false;
	private $date = 0;
	
	/**
	 * Initialize student
	 */
	function __construct(){
	
	}
	/**
	 * Create a new studentregistratie
	 *
	 * @param user studentregistratie  array
	 */
	public static function fromArray($student = array()){
		global $config;
		$instance = new self();
		$instance->setId($student['id']);
		$instance->setEmail($student['email']);
		$instance->setPrivateKey($student['privatekey']);
		$instance->setReceived($student['received']);
		return $instance;
	}
	
	/**
	 * Get Identifier
	 *
	 * @return Identifier
	 */
	function getId(){
		return $this->id;
	}
	
	/**
	 * Set Identifier
	 *
	 * @param id Identifier
	 */
	function setId($id = -1){
		$this->id = $id;
	}

	function getEmail(){
		return $this->email;
	}
	
	function setEmail($email){
		$this->email = $email;
	}
	
	function getPrivateKey(){
		return $this->privatekey;
	}
	
	function setPrivateKey($privatekey){
		$this->privatekey = $privatekey;
	}
	
	function isReceived(){
		return $this->received;
	}
	
	function setReceived($received){
		$this->received = $received;
	}
	
	function registrationToArray(){
		$data = array(
			'email' => $this->getEmail(),
			'privatekey' => $this->getPrivateKey(),
			'received' => $this->isReceived()
		);
		return $data;
	}
 }
 ?>