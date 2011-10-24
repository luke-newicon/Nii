<?php

class TestSetting extends CFormModel {

	public $id;
	public $name;
	public $color;
	public $size;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('id','required'),
			array('id, name, color, size', 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'color' => 'Colour',
			'size' => 'Size',
		);
	}
	
	public function settings(){
		return array(
			'id' => array('type' => 'text'),
		);
	}

}