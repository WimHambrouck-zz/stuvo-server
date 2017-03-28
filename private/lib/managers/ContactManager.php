<?php namespace mvdwcms\managers;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014
 * ------------------------------------- */
 
include_once (dirname(dirname(dirname(__FILE__))).'/include.php');

 class ContactManager{
 	var $db;
	
	/**
	 * Initialize contact manager
	 */
	function __construct($config = array()){
		$this -> db = new DatabaseManager($config['database']);
		$this -> initTable(false);
	}
	
	/**
	 * Initialize table
	 */
	function initTable($force){
		if (!$this->db->exists("contacts") || $force){
			$this -> db -> drop("contacts");
			$this -> db -> create("contacts", "`id` int(11) NOT NULL AUTO_INCREMENT,
				`firstname` varchar(50) NOT NULL,
				`lastname` varchar(50) NOT NULL,
				`prefix` varchar(50) NOT NULL,
				`email` varchar(100) NOT NULL,
				`mobile` varchar(50) NOT NULL,
				PRIMARY KEY (`id`)");
		}
	}
 
	/**
	 * Add a contact to the database
	 *
	 * @param contact Contact
	 * @return Identifier
	 */
	function addContact($contact = Contact){
		$this->db->insert("contacts",$contact->contactToArray());
		return $this->getLastId();
	}
	
	
	function editContact($id,$contact = Contact){
		$this -> db -> update("contacts", $contact->contactToArray(),'id=\''.$this->db->escape($id).'\'');
	}
	
	function removeContactById($uid){
		$this->db->delete("contacts","id=".$this->db->escape($uid));
	}
	
	/**
	 * Get last Identifier in the database
	 *
	 * @return Last identifier
	 */
	function getLastId(){
		$id = $this->db->row(array('table' => 'contacts','fields' => 'MAX(id)'));
		return $id['MAX(id)'];
	}
 }
 ?>