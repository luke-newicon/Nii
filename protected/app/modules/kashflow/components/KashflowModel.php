<?php

class KashflowModel extends CFormModel {

	private $_client;

	public function init() {
		if (!$this->_client)
			$this->_client = new SoapClient(Yii::app()->getModule('kashflow')->url);
	}

	public function request($function, $parameters=array()) {
		$parameters['UserName'] = Yii::app()->getModule('kashflow')->username;
		$parameters['Password'] = Yii::app()->getModule('kashflow')->password;
		return $this->handleResponse($this->_client->$function($parameters));
	}

	private function handleResponse($response) {
		if ("NO" == $response->Status)
			throw(new CHttpException(400, $response->StatusDetail));
		return $response;
	}

}