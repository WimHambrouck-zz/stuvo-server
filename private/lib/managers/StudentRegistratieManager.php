<?php namespace mvdwcms\managers;
/**
 * MVdW Content Management System
 *
 * @project MVdW CMS
 * @version 2014
 * @author Maxim Van de Wynckel
 */

include_once (dirname(dirname(dirname(__FILE__))).'/include.php');

 use mvdwcms\models\StudentRegistratie;

 class StudentRegistratieManager{
 	var $db;
	
 	/**
	 * Initialize permission Manager
	 */
	function __construct($config = array()){
		$this -> db = new DatabaseManager($config['database']);
		$this -> initTable(false);
	}

	/**
	 * Initialize table
	 */
	function initTable($force){
		if (!$this->db->exists("studenten") || $force){
			$this -> db -> drop("studenten");
			$this -> db -> create("studenten", "`id` int(11) NOT NULL AUTO_INCREMENT,
				`email` varchar(150) NOT NULL,
				`privatekey` varchar(150) NOT NULL,
				`received` BOOL NOT NULL,
				PRIMARY KEY (`id`)");
		}
	}

	function addRegistration($registration = StudentRegistratie){
		$this->db->insert("studenten",$registration->registrationToArray());
		return $this->getLastId();
	}
	
	
	function editRegistration($id,$registration = StudentRegistratie){
		$res = $this -> db -> update("studenten", $registration->registrationToArray(),'id=\''.$this->db->escape($id).'\'');
	}
	
	function hasRegistrated($email){
		$result = $this->db->row(array('table' => 'studenten','fields' => 'email','condition' => 'email = \''.$this->db->escape($email).'\''));
		return ($result == false ? false : true);
	}
	
	function isValid($code){
		$result = $this->db->row(array('table' => 'studenten','condition' => 'privatekey = \''.$this->db->escape($code).'\' AND received=0'));
		return $result == false ? false : StudentRegistratie::fromArray($result);
	}
	
	
	/**
	 * Get last Identifier in the database
	 *
	 * @return Last identifier
	 */
	function getLastId(){
		$id = $this->db->row(array('table' => 'studenten','fields' => 'MAX(id)'));
		return $id['MAX(id)'];
	}
 }
 ?>