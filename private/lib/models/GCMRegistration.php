<?php namespace mvdwcms\models;
/**
 * MVdW Content Management System
 *
 * @project MVdW CMS
 * @version 2014
 * @author Maxim Van de Wynckel
 */
 
include_once (dirname(dirname(dirname(__FILE__))).'/include.php');


 class GCMRegistration{
	private $regId = "";
    private $os = "";
	
	/**
	 * Initialize GCM
	 */
	function __construct(){
	
	}

	public static function fromArray($gcm = array()){
		global $config;
		$instance = new self();
		$instance->setRegistrationId($gcm['regId']);
        $instance->setOS($gcm['os']);
		return $instance;
	}

	function getRegistrationId(){
		return $this->regId;
	}
	
	function setRegistrationId($regId){
		$this->regId = $regId;
	}

    function getOS(){
        return $this->os;
    }
    
    function setOS($os){
        $this->os = $os;    
    }
    
	function toArray(){
		$data = array(
			'regId' => $this->getRegistrationId(),
            'os' => $this->getOS()
		);
		return $data;
	}
 }
 ?>