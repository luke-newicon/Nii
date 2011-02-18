<?php

/**
 * This is the model class for table "pm__nworx_crm_addresses".
 *
 * The followings are the available columns in table 'pm__nworx_crm_addresses':
 * @property string $address_id
 * @property string $address_lines
 * @property string $address_postcode
 * @property string $address_country_id
 * @property string $address_city
 * @property string $address_county
 * @property string $address_label
 * @property string $address_contact_id
 * @property string $address_verified
 *
 * The followings are the available model relations:
 * @property PmNworxCrmContacts $addressContact
 */
class PmNworxCrmAddresses extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PmNworxCrmAddresses the static model class
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
		return 'pm__nworx_crm_addresses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('address_lines, address_postcode, address_country_id, address_city, address_county, address_label, address_contact_id, address_verified', 'required'),
			array('address_postcode, address_country_id', 'length', 'max'=>10),
			array('address_city, address_county, address_label', 'length', 'max'=>250),
			array('address_contact_id', 'length', 'max'=>11),
			array('address_verified', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('address_id, address_lines, address_postcode, address_country_id, address_city, address_county, address_label, address_contact_id, address_verified', 'safe', 'on'=>'search'),
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
			'addressContact' => array(self::BELONGS_TO, 'PmNworxCrmContacts', 'address_contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'address_id' => 'Address',
			'address_lines' => 'Address Lines',
			'address_postcode' => 'Address Postcode',
			'address_country_id' => 'Address Country',
			'address_city' => 'Address City',
			'address_county' => 'Address County',
			'address_label' => 'Address Label',
			'address_contact_id' => 'Address Contact',
			'address_verified' => 'Address Verified',
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

		$criteria->compare('address_id',$this->address_id,true);
		$criteria->compare('address_lines',$this->address_lines,true);
		$criteria->compare('address_postcode',$this->address_postcode,true);
		$criteria->compare('address_country_id',$this->address_country_id,true);
		$criteria->compare('address_city',$this->address_city,true);
		$criteria->compare('address_county',$this->address_county,true);
		$criteria->compare('address_label',$this->address_label,true);
		$criteria->compare('address_contact_id',$this->address_contact_id,true);
		$criteria->compare('address_verified',$this->address_verified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}