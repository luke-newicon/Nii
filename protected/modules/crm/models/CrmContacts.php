<?php

/**
 * This is the model class for table "pm__nworx_crm_contacts".
 *
 * The followings are the available columns in table 'pm__nworx_crm_contacts':
 * @property string $contact_id
 * @property string $contact_title
 * @property string $contact_first_name
 * @property string $contact_last_name
 * @property string $contact_company
 * @property string $contact_company_id
 * @property string $contact_type
 *
 * The followings are the available model relations:
 * @property PmNworxCrmAddresses[] $pmNworxCrmAddresses
 * @property PmNworxCrmEmails[] $pmNworxCrmEmails
 * @property PmNworxCrmPhones[] $pmNworxCrmPhones
 * @property PmNworxCrmWebsites[] $pmNworxCrmWebsites
 */
class CrmContacts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CrmContacts the static model class
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
		return 'pm__nworx_crm_contacts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contact_title, contact_first_name, contact_last_name, contact_company, contact_company_id', 'required'),
			array('contact_title', 'length', 'max'=>50),
			array('contact_first_name, contact_last_name, contact_company', 'length', 'max'=>250),
			array('contact_company_id', 'length', 'max'=>11),
			array('contact_type', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('contact_id, contact_title, contact_first_name, contact_last_name, contact_company, contact_company_id, contact_type', 'safe', 'on'=>'search'),
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
			'pmNworxCrmAddresses' => array(self::HAS_MANY, 'PmNworxCrmAddresses', 'address_contact_id'),
			'pmNworxCrmEmails' => array(self::HAS_MANY, 'PmNworxCrmEmails', 'email_contact_id'),
			'pmNworxCrmPhones' => array(self::HAS_MANY, 'PmNworxCrmPhones', 'phone_contact_id'),
			'pmNworxCrmWebsites' => array(self::HAS_MANY, 'PmNworxCrmWebsites', 'website_contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'contact_id' => 'Contact',
			'contact_title' => 'Contact Title',
			'contact_first_name' => 'Contact First Name',
			'contact_last_name' => 'Contact Last Name',
			'contact_company' => 'Contact Company',
			'contact_company_id' => 'Contact Company',
			'contact_type' => 'Contact Type',
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

		$criteria->compare('contact_id',$this->contact_id,true);
		$criteria->compare('contact_title',$this->contact_title,true);
		$criteria->compare('contact_first_name',$this->contact_first_name,true);
		$criteria->compare('contact_last_name',$this->contact_last_name,true);
		$criteria->compare('contact_company',$this->contact_company,true);
		$criteria->compare('contact_company_id',$this->contact_company_id,true);
		$criteria->compare('contact_type',$this->contact_type,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}