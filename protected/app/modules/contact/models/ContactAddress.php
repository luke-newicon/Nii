<?php

/**
 * This is the model class for table "trinity.contact".
 *
 * The followings are the available columns in table 'trinity.contact':
 * @property integer $id
 * @property integer $contact_id
 * @property string $email
 * @property string $addr1
 * @property string $addr2
 * @property string $addr3
 * @property string $city
 * @property string $county
 * @property string $country
 * @property string $postcode
 * @property string $tel_primary
 * @property string $tel_secondary
 * @property string $mobile
 * @property string $fax
 */
class ContactAddress extends Contact
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contact_id', 'required'),
			array('email', 'length', 'max'=>75),
			array('addr1, addr2, addr3', 'length', 'max'=>100),
			array('city, county, country, tel_primary, tel_secondary, mobile, fax', 'length', 'max'=>50),
			array('postcode', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, addr1, addr2, addr3, city, county, country, postcode, tel_primary, tel_secondary, mobile, fax', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'addr1' => 'Address Line 1',
			'addr2' => 'Address Line 2',
			'addr3' => 'Address Line 3',
			'city' => 'City',
			'county' => 'County',
			'country' => 'Country',
			'postcode' => 'Postcode',
			'tel_primary' => 'Tel - Primary',
			'tel_secondary' => 'Tel - Secondary',
			'mobile' => 'Mobile',
			'fax' => 'Fax',
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('addr1',$this->addr1,true);
		$criteria->compare('addr2',$this->addr2,true);
		$criteria->compare('addr3',$this->addr3,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('county',$this->county,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('tel_primary',$this->tel_primary,true);
		$criteria->compare('tel_secondary',$this->tel_secondary,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('fax',$this->fax,true);

		return new NActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function sortAddressFields() {
		return array(
			'addr1' => 'contact.addr1',
			'addr2' => 'contact.addr2',
			'addr3' => 'contact.addr3',
			'city' => 'contact.city',
			'county' => 'contact.county',
			'country' => 'contact.country',
			'postcode' => 'contact.postcode',
			'tel_primary' => 'contact.tel_primary',
			'tel_secondary' => 'contact.tel_secondary',
			'mobile' => 'contact.mobile',
			'fax' => 'contact.fax',
			'name' => 'contact.name',
			'email' => 'contact.email',
			'lastname' => 'contact.lastname',
			'givennames' => 'contact.givennames',
			'title' => 'contact.title',
		);
	}
	
	public function addressFieldLabels() {
		return array_merge($this->attributeLabels(),array(
			'contact.addr1' => 'Address Line 1',
			'contact.addr2' => 'Address Line 2',
			'contact.addr3' => 'Address Line 3',
			'contact.tel_primary' => 'Tel - Primary',
			'contact.tel_secondary' => 'Tel - Secondary',
			'contact.lastname' => 'Name',
			'contact.postcode' => 'Post Code',
			'contact_name' => 'Contact Name',
			'contact.givennames' => 'Given Names',
			'contact.lastname' => 'Surname',
		));
	}
	
	public function addressCompareFields(&$criteria, $model) {
		$criteria->compare('contact.name',$model->name,true);
		$criteria->compare('contact.tel_primary',$model->tel_primary,true);
		$criteria->compare('contact.tel_secondary',$model->tel_secondary,true);
		$criteria->compare('contact.mobile',$model->mobile,true);
		$criteria->compare('contact.email',$model->email,true);
		$criteria->compare('contact.addr1',$model->addr1,true);
		$criteria->compare('contact.addr2',$model->addr2,true);
		$criteria->compare('contact.addr3',$model->addr3,true);
		$criteria->compare('contact.city',$model->city,true);
		$criteria->compare('contact.county',$model->county,true);
		$criteria->compare('contact.country',$model->country,true);
		$criteria->compare('contact.postcode',$model->postcode,true);
	}
	
	public function personCompareFields(&$criteria, $model) {
		$criteria->compare('contact.title',$model->title,true);
		$criteria->compare('contact.givennames',$model->givennames,true);
		$criteria->compare('contact.lastname',$model->lastname,true);
	}
	
}