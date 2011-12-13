<?php

class ContactGroupContact extends NActiveRecord 
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}		
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{contact_group_contact}}';
	}
	
	public function relations() {
		return array(
			'contact'=>array(self::BELONGS_TO, 'HftContact', 'contact_id'),
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'contact_id' => 'Contact',
			'group_id' => 'Group',
		);
	}


	public function schema() {
		return array(
			'columns' => array(
				'id' => 'pk',
				'contact_id' => "int(11)",
				'group_id' => "int(11)",
			),
			'keys' => array());
	}
	
}