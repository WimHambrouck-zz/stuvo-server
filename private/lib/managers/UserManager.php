<?php namespace mvdwcms\managers;
/**
 * MVdW Content Management System
 *
 * @project MVdW CMS
 * @version 2014
 * @author Maxim Van de Wynckel
 */

include_once (dirname(dirname(dirname(__FILE__))).'/include.php');

use mvdwcms\models\User;
use mvdwcms\managers\ContactManager;

class UserManager {
	private $db;
	
	/**
	 * Initialize user manager
	 */
	function __construct($config = array()){
		$this -> db = new DatabaseManager($config['database']);
		$this -> initTable(false);
	}

	/**
	 * Initialize table
	 */
	function initTable($force){
		if (!$this->db->exists("users") || $force){
			$this -> db -> drop("users");
			$this -> db -> create("users", "`id` int(11) NOT NULL AUTO_INCREMENT,
				`cid` int(11) NOT NULL,
				`username` varchar(30) NOT NULL,
				`password` varchar(50) NOT NULL,
				`group` INT NOT NULL DEFAULT '1',
				`active` INT(1) NOT NULL DEFAULT '1',
				PRIMARY KEY (`id`)");
		}
		if (!$this->db->exists("user_sessions") || $force){
			$this -> db -> drop("user_sessions");
			$this -> db -> create("user_sessions", "`sid` int(10) NOT NULL AUTO_INCREMENT,
				`uid` int(10) NOT NULL,
				`session` varchar(100) NOT NULL,
				`created` datetime NOT NULL,
				`expires` datetime NOT NULL,
				PRIMARY KEY (`sid`)");
		}
	}
	
	/**
	 * Add a user to the database
	 *
	 * @param user User
	 */
	function addUser($user) {
		global $config;
		$contactManager = new ContactManager($config);
		$id = $contactManager->addContact($user);
		$this -> db -> insert("users", array_merge($user->userToArray(),array('cid' => $this->db->escape($id))));
	}
	
	/**
	 * Edit a user from the database
	 *
	 * @param id User Identfier
	 * @param user User
	 */
	function editUser($id, $user){
		global $config;
		$contactManager = new ContactManager($config);
		$contactManager->editContact($user->getContactId(),$user);
		$this -> db -> update("users", $user->userToArray(),'id=\''.$this->db->escape($id).'\'');
	}
	function removeUserById($uid){
		global $config;
		$user = $this->getUserById($uid);
		$cid = $user->getContactId();
		$this->db->delete("users","id=".$this->db->escape($uid));
		$contactManager = new ContactManager($config);
		$contactManager->removeContactById($cid);
	}

	/**
	 * Get user by identifier
	 *
	 * @param id Identifier
	 */
	function getUserById($id) {
		$result = $this -> db -> row(array('table' => 'users u JOIN '.$this->db->getPrefix().'contacts c ON (u.cid=c.id)', 'condition' => 'u.id=\''.$this->db->escape($id).'\''));
		$user = User::fromArray($result);
		return $user;
	}
	
	function getUsers($count,$page){
		$contacts = array();
		$result = $this -> db -> select(array('table' => 'users u JOIN '.$this->db->getPrefix().'contacts c ON (u.cid=c.id)','limit' => (($page - 1)*$count).' , '.$count));
		for($i = 0; $i < sizeof($result); $i++){
			$user = array_merge($result[$i]['u'],$result[$i]['c']);
			array_push($contacts,User::fromArray($user));
		}
		return $contacts;
	}
	
	function getCount(){
		$count =  $this->db->row(array('table' => 'users','fields' => 'COUNT(id)'));
		return $count['COUNT(id)'];
	}

}
?>