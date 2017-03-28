<?php namespace mvdwcms\models;
/**
 * MVdW Content Management System
 *
 * @project MVdW CMS
 * @version 2014
 * @author Maxim Van de Wynckel
 */
 
 class Contact{
	private $cid = -1;
	private $firstname = "";
	private $lastname = "";
	private $email = "";
	
	/**
	 * Initialize user
	 */
	function __construct(){
	
	}
	
	/**
	 * Create a new contact
	 *
	 * @param firstname First Name
	 * @param lastname Last Name
	 */
	public static function fromName($firstname, $lastname){
		$instance = new self();
		$instance->firstname = $firstname;
		$instance->lastname = $lastname;
		return $instance;
	}
	
	/**
	 * Create a new contact
	 *
	 * @param contact Array
	 */
	public static function contactFromArray($contact = array()){
		$instance = new self();
		$instance->setFirstName($contact['firstname']);
		$instance->setLastName($contact['lastname']);
		$instance->setEmail($contact['email']);
		return $instance;
	}
	
	/**
	 * Get Identifier
	 *
	 * @return Identifier
	 */
	function getContactId(){
		return $this->cid;
	}
	
	/**
	 * Set Identifier
	 *
	 * @param id Identifier
	 */
	function setContactId($id = -1){
		$this->cid = $id;
	}
	
	/**
	 * Get first name
	 *
	 * @return First name
	 */
	function getFirstName(){
		return htmlentities(utf8_encode($this->firstname));
	}
	
	/**
	 * Set first name
	 *
	 * @param firstname First name
	 */
	function setFirstName($firstname){
		$this->firstname = htmlentities(utf8_decode($firstname));
	}
	
	/**
	 * Get last name
	 *
	 * @return Last name
	 */
	function getLastName(){
		return htmlentities(utf8_encode($this->lastname));
	}
	
	/**
	 * Set last name
	 *
	 * @param lastname Last name
	 */
	function setLastName($lastname){
		$this->lastname = htmlentities(utf8_decode($lastname));
	}
	
	function getEmail(){
		return htmlentities(utf8_encode($this->email));
	}
	
	function setEmail($email){
		$this->email = htmlentities(utf8_decode($email));
	}
	
	
	/**
	 * Convert contact to array
	 *
	 * @return Array
	 */
	function contactToArray(){
		$data = array(
			'firstname' => $this->getFirstname(),
			'lastname' => $this->getLastName(),
			'email' => $this->getEmail()
		);
		return $data;
	}
 }
 ?>