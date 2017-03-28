<?php namespace mvdwcms\managers;
/**
 * MVdW Content Management System
 *
 * @project MVdW CMS
 * @version 2014
 * @author Maxim Van de Wynckel
 */

include_once (dirname(dirname(dirname(__FILE__))).'/include.php');

 use mvdwcms\models\Permission;
 use mvdwcms\models\User;
 use mvdwcms\models\UserGroup;
 
 class PermissionManager{
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
		if (!$this->db->exists("permissions") || $force){
			$this -> db -> drop("permissions");
			$this -> db -> create("permissions", "`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(50) NOT NULL,
				`description` varchar(150) NOT NULL,
				PRIMARY KEY (`id`)");
		}
		if (!$this->db->exists("permissions_group") || $force){	
			$this -> db -> drop("permissions_group");
			$this -> db -> create("permissions_group", "`pid` int(11) NOT NULL,
				`gid` int(11) NOT NULL,
				PRIMARY KEY (`pid`, `gid`)");
		}
	}
	
	/**
	 * Add a permission to the database
	 *
	 * @param permission Permission
	 */
	function addPermission($permission) {
		$this -> db -> insert("permissions", $permission->toArray());
	}
	
	function grantPermission($usergroup,$permission){
		$this -> db -> insert("permissions_group", array('gid' => $this->db->escape($usergroup->getId()),'pid' => $this->db->escape($permission->getId())));
	}
	
	function ungrantPermission($usergroup,$permission){
		$this -> db -> delete("permissions_group",'gid='.$this->db->escape($usergroup->getId()).' AND pid='.$this->db->escape($permission->getId()));
	}
	
	function hasPermission($usergroup , $permission){
		$groupId = $usergroup->getId();
		$permissionId = $permission->getId();
		$result = $this -> db -> row(array('table' => 'permissions_group', 'condition' => 'gid=\''.$this->db->escape($groupId).'\' AND pid=\''.$this->db->escape($permissionId).'\''));
		if ($result == false){
			return false;
		}else{
			return true;
		}
	}

	/**
	 * Get permission by identifier
	 *
	 * @param id Identifier
	 */
	function getPermissionById($id) {
		$result = $this -> db -> row(array('table' => 'permissions', 'condition' => 'id=\''.$this->db->escape($id).'\''));
		$permission = Permission::fromArray($result);
		return $permission;
	}
	
	function getPermissionByName($name){
		$result = $this -> db -> row(array('table' => 'permissions', 'condition' => 'name=\''.$this->db->escape($name).'\''));
		$permission = Permission::fromArray($result);
		return $permission;
	}
	
	/**
	 * Get all user groups
	 *
	 * @return User groups
	 */
	function getPermissions(){
		$permissions = array();
		$result = $this -> db -> select(array('table' => 'permissions'));
		for($i = 0; $i < sizeof($result); $i++){
			$permission = Permission::fromArray($result[$i]['permissions']);
			array_push($permissions,$permission);
		}
		return $permissions;
	}
	
	function getPermissionsByGroup($usergroup){
		$permissions = array();
		$result = $this -> db -> select(array('table' => 'permissions_group','condition' => 'gid='.$this->db->escape($usergroup->getId())));
		for($i = 0; $i < sizeof($result); $i++){
			$pid = $result[$i]['permissions_group']['pid'];
			$permission = $this->getPermissionById($pid);
			array_push($permissions,$permission);
		}
		return $permissions;
	}

 }
 ?>