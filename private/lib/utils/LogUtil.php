<?php namespace mvdwcms\utils;
/**
 * MVdW Content Management System
 *
 * @project MVdW CMS
 * @version 2014
 * @author Maxim Van de Wynckel
 */

include_once (dirname(dirname(dirname(__FILE__))).'/include.php');

use mvdwcms\managers\DatabaseManager;

class LogUtil{
	private $db;
	
	/**
	 * Initialize user manager
	 */
	function __construct($config = array()){
		$this -> db = new DatabaseManager($config['database']);
	}
	
	/**
	 * Get manager instance
	 *
	 * @return Instance
	 */
	public static function getInstance(){
		return $this->instance;
		$this->initTable(false);
	}
	
	/**
	 * Initialize table
	 */
	function initTable($force){
		if (!$this->db->exists("log") || $force){
			$this -> db -> drop("log");
			$this -> db -> create("log", "`id` int(11) NOT NULL AUTO_INCREMENT,
				`uid` int(11) NOT NULL,
				`time` int(11) NOT NULL,
				`type` int(11) NOT NULL,
				`message` varchar(500) NOT NULL,
				PRIMARY KEY (`id`)");
		}
	}

	function addLog($user,$type, $message){
		$id = 0;
		if (isset($user))
			$id = $user->getId();
		$this->db->insert("log",array('uid' => $id, 'time' => time(), 'type' => $type, 'message' => $message));
	}
	
	function error($user,$message){
		$this->addLog($user,0,$message);
	}
	
	function warning($user,$message){
		$this->addLog($user,0,$message);
	}
	
	function info($user,$message){
		$this->addLog($user,0,$message);
	}
	
	function login($user,$message){
		$this->addLog($user,0,$message);
	}
	
	function logout($user,$message){
		$this->addLog($user,0,$message);
	}
	
	function search($user,$message){
		$this->addLog($user,0,$message);
	}

	function getLogs($count,$page){
		$logs = array();
		$result =  $this -> db -> select(array('table' => 'log' ,'limit' => (($page - 1)*$count).' , 50','order' => 'time DESC'));
		return $result;
	}
	
	function getCount(){
		$count =  $this->db->row(array('table' => 'log','fields' => 'COUNT(id)'));
		return $count['COUNT(id)'];
	}
}
?>