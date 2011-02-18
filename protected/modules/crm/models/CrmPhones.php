<?php

/**
 * This is the model class for table "pm__nworx_crm_phones".
 *
 * The followings are the available columns in table 'pm__nworx_crm_phones':
 * @property string $phone_id
 * @property string $phone_number
 * @property string $phone_label
 * @property string $phone_contact_id
 * @property string $phone_verified
 *
 * The followings are the available model relations:
 * @property PmNworxCrmContacts $phoneContact
 */
class CrmPhones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CrmPhones the static model class
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
		return 'pm__nworx_crm_phones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('phone_number, phone_label, phone_contact_id, phone_verified', 'required'),
			array('phone_number, phone_label', 'length', 'max'=>250),
			array('phone_contact_id', 'length', 'max'=>11),
			array('phone_verified', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('phone_id, phone_number, phone_label, phone_contact_id, phone_verified', 'safe', 'on'=>'search'),
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
			'phoneContact' => array(self::BELONGS_TO, 'PmNworxCrmContacts', 'phone_contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'phone_id' => 'Phone',
			'phone_number' => 'Phone Number',
			'phone_label' => 'Phone Label',
			'phone_contact_id' => 'Phone Contact',
			'phone_verified' => 'Phone Verified',
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

		$criteria->compare('phone_id',$this->phone_id,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('phone_label',$this->phone_label,true);
		$criteria->compare('phone_contact_id',$this->phone_contact_id,true);
		$criteria->compare('phone_verified',$this->phone_verified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}