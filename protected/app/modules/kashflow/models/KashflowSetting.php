<?php

class KashflowSetting extends CFormModel {

	public $username;
	public $password;
	
	public function init(){
		foreach($this->attributes as $key => $attribute)
			$this->$key = Yii::app()->getModule('kashflow')->$key;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('username, password', 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'username' => 'Username',
			'password' => 'Password',
		);
	}
	
	public function save(){
		$settings = array('kashflow'=>$this->attributes);
		$settings = CMap::mergeArray(Yii::app()->settings->get('modules','config'), $settings);
		Yii::app()->settings->set('modules',$settings,'config');
		return true;
	}

}