<?php

class Profile extends NiiActiveRecord
{
	/**
	 * The followings are the available columns in table 'profiles':
	 * @var integer $user_id
	 * @var boolean $regMode
	 */
	public $regMode = false;
	
	private $_model;
	private $_modelReg;

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
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
		return Yii::app()->getModule('user')->tableProfiles;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$required = array();
		$numerical = array();		
		$rules = array();
		
		return $rules;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		$user = UserModule::get()->userClass;
		return array(
			'user'=>array(self::HAS_ONE, $user, 'id'),
		);
	}

	
}