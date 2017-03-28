<?php namespace mvdwcms\managers;
/**
 * MVdW Content Management System
 *
 * @project MVdW CMS
 * @version 2014
 * @author Maxim Van de Wynckel
 */

include_once (dirname(dirname(dirname(__FILE__))).'/include.php');
 use mvdwcms\models\UserGroup;
 
 class UserGroupManager{
 	var $db;
	
 	/**
	 * Initialize usergroup manager
	 */
	function __construct($config = array()){
		$this -> db = new DatabaseManager($config['database']);
		$this -> initTable(false);
	}

	/**
	 * Initialize table
	 */
	function initTable($force){
		if (!$this->db->exists("user_groups") || $force){
			$this -> db -> drop("user_groups");
			$this -> db -> create("user_groups", "`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(50) NOT NULL,
				PRIMARY KEY (`id`)");
		}
	}
	
	/**
	 * Add a group to the database
	 *
	 * @param group Group
	 */
	function addUserGroup($usergroup) {
		$this -> db -> insert("user_groups", $usergroup->toArray());
	}
	

	/**
	 * Get usergroup by identifier
	 *
	 * @param id Identifier
	 */
	function getUserGroupById($id) {
		$result = $this -> db -> row(array('table' => 'user_groups', 'condition' => 'id=\''.$this->db->escape($id).'\''));
		$usergroup = UserGroup::fromArray($result);
		return $usergroup;
	}
	
	/**
	 * Get all user groups
	 *
	 * @return User groups
	 */
	function getUserGroups(){
		$usergroups = array();
		$result = $this -> db -> select(array('table' => 'user_groups'));
		for($i = 0; $i < sizeof($result); $i++){
			$usergroup = UserGroup::fromArray($result[$i]['user_groups']);
			array_push($usergroups,$usergroup);
		}
		return $usergroups;
	}

 }
 ?>