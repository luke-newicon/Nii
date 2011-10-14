<?php

/**
 * This is the model class for table "Nii.setting".
 *
 * The followings are the available columns in table 'nii.setting':
 * @property integer $id
 * @property integer $user_id
 * @property string $setting_name
 * @property string $setting_value
 */
class Setting extends NActiveRecord
{
	
	public static function install($className=__CLASS__){
		return parent::install();
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Setting the static model class
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
		return '{{nii_setting}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('key', 'length', 'max'=>255),
			array('category', 'length', 'max'=>64),
			array('category, key, value', 'safe'),
		);
	}

	
	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'category' => "varchar(64) NOT NULL default 'system'",
				'key' => "varchar(255)",
				'value' => "text",
				'trashed' => "int(1) unsigned NOT NULL",
			),
			'keys' => array(
				array('category_key','category,key')
			)
		);
	}
	
}