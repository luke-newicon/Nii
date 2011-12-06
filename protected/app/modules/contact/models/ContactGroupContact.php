<?php

class ContactGroupContact extends NActiveRecord {
		
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{contact_group_contact}}';
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