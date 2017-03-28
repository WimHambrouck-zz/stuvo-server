<?php namespace mvdwcms\models;
/**
 * MVdW Content Management System
 *
 * @project MVdW CMS
 * @version 2014
 * @author Maxim Van de Wynckel
 */
 
class Permission{
	private $id = -1;
	private $name = "";
	private $description = "";

	/**
	 * Initialize permission
	 */
	function __construct(){
	
	}
	
	/**
	 * Create a new permission
	 *
	 * @param name Name
	 */
	public static function fromName($name,$description){
		$instance = new self();
	    $instance->setName($name);
		$instance->setDescription($description);
		return $instance;
	}
	
	/**
	 * Create a new permissoin
	 *
	 * @param user Permission array
	 */
	public static function fromArray($permission = array()){
		global $config;
		$instance = new self();
		$instance->setName($permission['name']);
		$instance->setDescription($permission['description']);
		$instance->setId($permission['id']);
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
	 * Get name
	 *
	 * @return Name
	 */
	function getName(){
		return htmlentities(utf8_encode($this->name));
	}
	
	/**
	 * Set name
	 *
	 * @param name Name
	 */
	function setName($name){
		$this->name = htmlentities(utf8_decode($name));
	}
	
	function getDescription(){
		return htmlentities(utf8_encode($this->description));
	}
	
	function setDescription($description){
		$this->description = htmlentities(utf8_decode($description));
	}

	
	/**
	 * Convert user to array
	 *
	 * @return Array
	 */
	function toArray(){
		$data = array(
			'name' => $this->getName(),
			'description' => $this->getDescription()
		);
		return $data;
	}
 }
?>