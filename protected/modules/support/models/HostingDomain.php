<?php

/**
 * This is the model class for table "hosting_domain".
 *
 * The followings are the available columns in table 'hosting_domain':
 * @property string $id
 * @property string $domain
 * @property string $registered_date
 * @property string $expires_date
 * @property string $registered_with
 * @property string $contact_id
 *
 * The followings are the available model relations:
 * @property CrmContact $contact
 */
class HostingDomain extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return HostingDomain the static model class
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
		return 'hosting_domain';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('domain, registered_date, expires_date, registered_with, contact_id', 'required'),
			array('domain, registered_with', 'length', 'max'=>250),
			array('contact_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, domain, registered_date, expires_date, registered_with, contact_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'contact' => array(self::BELONGS_TO, 'CrmContact', 'contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'domain' => 'Domain',
			'registered_date' => 'Registered Date',
			'expires_date' => 'Expires Date',
			'registered_with' => 'Registered With',
			'contact_id' => 'Contact',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('domain',$this->domain,true);
		$criteria->compare('registered_date',$this->registered_date,true);
		$criteria->compare('expires_date',$this->expires_date,true);
		$criteria->compare('registered_with',$this->registered_with,true);
		$criteria->compare('contact_id',$this->contact_id,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}