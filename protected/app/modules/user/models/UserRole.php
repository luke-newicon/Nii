<?php

class UserRole extends AuthItem {

	public $copy;

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function rules() {
		return array(
			array('name', 'nameIsAvailable', 'on'=>'insert'),
			array('name', 'required'),
			array('name', 'length', 'max'=>64, 'min'=>1),
			array('description, copy', 'safe'),
			array('name, description, type', 'safe', 'on'=>'search'),
		);
	}

	public function defaultScope() {
		return array(
			'condition' => 'type = 2',
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'name' => 'Name',
			'description' => 'Description',
			'bizRule' => 'Business rule',
			'data' => 'Data',
			'copy' => 'Copy from existing role',
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'children' => array(self::HAS_MANY, 'AuthItemChild', 'child'),
		);
	}

}