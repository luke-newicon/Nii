<?php
/**
 * @property id
 * @property name
 */
Class CrmGroupContact extends NAppRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CrmEmail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{crm_group_contact}}';
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'contact_id' => 'Contact ID',
			'group_id' => 'Group ID',
		);
	}
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}

	public function schema(){
		return array(
			'columns'=>array(
				'group_id'=>'int',
				'contact_id'=>'int',
				0=>'PRIMARY KEY (group_id, contact_id)'
			),
		);
	}
}