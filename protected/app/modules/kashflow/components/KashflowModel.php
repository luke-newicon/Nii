<?php

class KashflowModel extends CFormModel {
	
	private $_client;
	
	public $wsdl = 'https://securedwebapp.com/api/service.asmx?WSDL';
	public $username;
	public $password;
	
	public function init(){
		if(!$this->_client)
			$this->_client = new SoapClient('https://securedwebapp.com/api/service.asmx?WSDL');
		
		$this->username = Yii::app()->getModule('kashflow')->username;
		$this->password = Yii::app()->getModule('kashflow')->password;
	}
	
	public function request($function, $parameters=array()){
		$parameters['UserName'] = $this->username;
		$parameters['Password'] = $this->password;
		return $this->_client->$function($parameters);
	}
}