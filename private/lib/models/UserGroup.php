<?php namespace mvdwcms\models;
/**
 * MVdW Content Management System
 *
 * @project MVdW CMS
 * @version 2014
 * @author Maxim Van de Wynckel
 */
 
 class UserGroup{
	private $id = 0;
	private $name = "Default";
	
	function __construct(){

	}
	
	public static function fromArray($group = array()){
		$instance = new self();
		$instance->setId($group['id']);
		$instance->setName($group['name']);
		return $instance;
	}
	
	public static function fromId($id, $name){
		$instance = new self();
		$instance->setName($name);
		$instance->setId($id);
		return $instance;
	}
	
	/**
	 * Get group name
	 *
	 * @return Name
	 */
	function getName(){
		return $this->name;
	}
 
	/**
	 * Set group name
	 *
	 * @param Group Name
	 */
	function setName($name){
		$this->name = $name;
	}
	
	/**
	 * Get group id
	 *
	 * @return Identifier
	 */
	function getId(){
		return $this->id;
	}
	
	/**
	 * Set group id
	 *
	 * @param id Group ID
	 */
	function setId($id){
		$this->id= $id;
	}
	
	/**
	 * Convert usergroup to array
	 *
	 * @return Array
	 */
	function toArray(){
		$data = array(
			'id' => $this->getId(),
			'name' => $this->getName()
		);
		return $data;
	}
 }
?>