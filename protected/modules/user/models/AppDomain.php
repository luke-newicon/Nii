<?php

/**
 * {name} class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * App domains stores a list of subdomains that identify the app instace
 *
 * @author steve
 */
class AppDomain extends NActiveRecord
{
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
		return '{{user_appdomain}}';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{	
		return array(
			array('domain','required'),
			array('domain', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect characters (A-z0-9).")),
			array('domain','length', 'max'=>50, 'min' => 3,'message' =>UserModule::t("The address must be between 3 and 250 characters long")),
			array('domain', 'unique', 'message'=>'This address already exists')
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'domain'=>UserModule::t("Domain"),
		);
	}

	public function schema(){
		return array(
			'columns'=>array(
				'domain'=>'string',
				0=>'PRIMARY KEY (domain)'
			)
		);
	}
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
}
