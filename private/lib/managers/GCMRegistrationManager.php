<?php namespace mvdwcms\managers;
/**
 * MVdW Content Management System
 *
 * @project MVdW CMS
 * @version 2014-2016
 * @author Maxim Van de Wynckel
 */

include_once (dirname(dirname(dirname(__FILE__))).'/include.php');

 use mvdwcms\models\GCMRegistration;

 class GCMRegistrationManager{
 	var $db;
	
	
 	/**
	 * Initialize permission Manager
	 */
	function __construct($config = array()){
		$this -> db = new DatabaseManager($config['database']);
		$this -> initTable(false);
	}

	function getRegistrations(){
		$registrations = array();
		$result = $this -> db -> select(array('table' => 'gcmregistrations','limit'=> '100000'));
		for($i = 0; $i < sizeof($result); $i++){
			$registration = GCMRegistration::fromArray($result[$i]['gcmregistrations']);
			array_push($registrations,$registration);
		}
		return $registrations;
	}
	/**
	 * Initialize table
	 */
	function initTable($force){
		if (!$this->db->exists("gcmregistrations") || $force){
			$this -> db -> drop("gcmregistrations");
			$this -> db -> create("gcmregistrations", "`regId` varchar(150) NOT NULL,
                `os` varchar(25) NOT NULL,
				PRIMARY KEY (`regId`)");
		}
	}

	function addRegistration($registration = GCMRegistration){
		$this->db->insert("gcmregistrations",$registration->toArray());
		return $this->getLastId();
	}
	
	
	function editRegistration($id,$registration = StudentRegistratie){
		$res = $this -> db -> update("gcmregistrations", $registration->toArray(),'regId=\''.$this->db->escape($id).'\'');
	}
	
	/**
	 * Get last Identifier in the database
	 *
	 * @return Last identifier
	 */
	function getLastId(){
		$id = $this->db->row(array('table' => 'gcmregistrations','fields' => 'MAX(regId)'));
		return $id['MAX(regId)'];
	}
 }
 ?>