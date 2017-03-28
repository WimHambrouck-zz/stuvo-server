<?php namespace mvdwcms\models;
/**
 * MVdW Content Management System
 *
 * @project MVdW CMS
 * @version 2014
 * @author Maxim Van de Wynckel
 */
 
include_once (dirname(dirname(dirname(__FILE__))).'/include.php');

use mvdwcms\managers\UserGroupManager;

 class User extends Contact{
	private $id = -1;
	private $username = "";
	private $password = "";
	private $passwordMD5 = "";
	private $group = null;
	private $active = true;
	
	/**
	 * Initialize user
	 */
	function __construct(){
	
	}
	
	/**
	 * Create a new user
	 *
	 * @param firstname First Name
	 * @param lastname Last Name
	 * @param username User name
	 * @param password Plain password
	 * @param group Group
	 */
	public static function fromName($firstname, $lastname){
		$instance = new self();
	    $instance->setFirstName($firstname);
		$instance->setLastName($lastname);
		return $instance;
	}
	
	/**
	 * Create a new user
	 *
	 * @param user User array
	 */
	public static function fromArray($user = array()){
		global $config;
		$instance = new self();
		$instance->username = $user['username'];
		$instance->passwordMD5 = $user['password'];
		$instance->setFirstName($user['firstname']);
		$instance->setLastName($user['lastname']);
		$instance->setContactId($user['cid']);
		$instance->setId($user['id']);
		$instance->setEmail($user['email']);
		$userGroupManager = new UserGroupManager($config);
		$instance->setGroup($userGroupManager->getUserGroupById($user['group']));
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
	
	/**
	 * Get username
	 *
	 * @return Username
	 */
	function getUsername(){
		return $this->username;
	}
	
	/**
	 * Set username
	 *
	 * @param username Username
	 */
	function setUsername($username){
		$this->username = $username;
	}
	
	/**
	 * Get plain password
	 *
	 * @return Plain password
	 */
	function getPlainPassword(){
		return $this->password;
	}
	
	/**
	 * Set plain password
	 *
	 * @param password Plain password
	 */
	function setPlainPassword($password){
		$this->password = $password;
		$this->passwordMD5 = md5($password);
	}
	
	/**
	 * Get encrypted password
	 *
	 * @return password Password as MD5 Hash
	 */
	function getPasswordMD5(){
		return $this->passwordMD5;
	}
	
	/**
	 * Set password MD5
	 *
	 * @param password Password as MD5
	 */
	function setPasswordMD5($password){
		$this->passwordMD5 = $password;
	}
	
	/**
	 * Get user group
	 *
	 * @return User Group
	 */
	function getGroup(){
		return $this->group;
	}
	
	/**
	 * Set user group
	 *
	 * @param group User Group
	 */
	function setGroup($group){
		$this->group = $group;
	}
	
	function isActive(){
		return $this->active;
	}
	
	function setActive($active){
		$this->active = $active;
	}
	
	/**
	 * Convert user to array
	 *
	 * @return Array
	 */
	function userToArray(){
		$data = array(
			'cid' => $this->getContactId(),
			'username' => $this->getUsername(),
			'password' => $this->getPasswordMD5(),
			'group' => $this->getGroup()->getId(),
			'active' => $this->isActive()
		);
		return $data;
	}
 }
 ?>