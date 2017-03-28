<?php namespace mvdwcms\managers;
/* --------------------------------------
 * MVdW CMS
 * @copyright Maxim Van de Wynckel 2014
 * ------------------------------------- */

session_start();
include_once (dirname(__FILE__).'/DatabaseManager.php');
include_once (dirname(__FILE__).'/../../config.php');

class SessionManager {
	var $db;
	
	/**
	 * Initialize session manager
	 */
	function __construct($config = array()){		
		$this -> db = new DatabaseManager($config['database']);
	}

	function isLoggedIn() {
		if (isset($_SESSION['user_session']) && isset($_SESSION['user_id'])) {
			$result = $this -> db -> row(array('table' => 'user_sessions', 'condition' => 'session=\'' . $this -> db->escape($_SESSION['user_session']) . '\''));
			if ($result) {
				if ($result['uid'] == $_SESSION['user_id']){
					$endTime= strtotime($result['expires']);
					$curTime= strtotime(date('Y-m-d H:i:s'));
					if ($endTime > $curTime){
						return $_SESSION['user_id'];
					}else{
						return -1;
					}
				} else {
					return -1;
				}
			} else {
				return -1;
			}
		} else {
			return -1;
		}
	}
	
	function getLoginDate(){
		if ($this->isLoggedIn() != -1){
			$result = $this -> db -> row(array('table' => 'user_sessions', 'condition' => 'session=\'' . $this -> db->escape($_SESSION['user_session']). '\''));
			if ($result) {
				$session = $result['session'];
				if ($session != NULL) {
					return $result['created'];
				}
			}
		}
		return "";
	}
	
	function getExpireDate(){
		if ($this->isLoggedIn() != -1){
			$result = $this -> db -> row(array('table' => 'user_sessions', 'condition' => 'session=\'' . $this -> db->escape($_SESSION['user_session']). '\''));
			if ($result) {
				$session = $result['session'];
				if ($session != NULL) {
					return $result['expires'];
				}
			}
		}
		return "";
	}

	function logOut() {
		if ($this->isLoggedIn()) {
			$userId = $_SESSION['user_id'];
			$session = $_SESSION['user_session'];
			unset($_SESSION['user_id']);
			unset($_SESSION['user_session']);
			$this -> db -> delete("user_sessions", "session = '" . $this -> db->escape($session) . "' AND uid = '" . $this -> db->escape($userId) ."'");
		}
	}
	

	function logIn($username, $passwordMD5) {
		global $config;
		$result = $this -> db -> row(array('table' => 'users', 'condition' => 'username=\'' .  $this -> db->escape($username) . '\' AND password=\'' .$passwordMD5 . '\''));
        if ($result != NULL) {
			// User logged in
			$userId = $result['id'];
			$session = uniqid("");
			$_SESSION['user_session'] = $session;
			$_SESSION['user_id'] = $userId;
			$beginDate = date('Y-m-d H:i:s');
			$endDate = date('Y-m-d H:i:s',strtotime("+".$config['sessiontime']." hours"));
			$data = array('session' => $session, 'created' => $beginDate, 'expires' => $endDate);
			$sessionResult = $this->db->select(array('table' => "user_sessions",'condition' => 'uid='.$userId));
			if ($sessionResult){
				if(sizeof($sessionResult) >= $config['sessioncount']){

				}
			}
			$data = array('session' => $session, 'created' => $beginDate, 'expires' => $endDate,'uid' => $userId);
			$this -> db -> insert("user_sessions", $data);
			return $userId;
		} else {
			return -1;
		}
	}

}
?>