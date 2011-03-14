<?php

/**
 * This is the model class for table "hosting_hosting".
 *
 * The followings are the available columns in table 'hosting_hosting':
 * @property string $id
 * @property string $domain_id
 * @property string $server
 * @property string $product
 * @property string $price
 * @property string $expires_date
 * @property string $start_date
 * @property string $contact_id
 *
 * The followings are the available model relations:
 * @property CrmContact $contact
 */
class HostingHosting extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return HostingHosting the static model class
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
		return 'hosting_hosting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('domain_id, server, product, price, expires_date, start_date, contact_id', 'required'),
			array('domain_id, contact_id', 'length', 'max'=>11),
			array('server, product', 'length', 'max'=>250),
			array('price', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, domain_id, server, product, price, expires_date, start_date, contact_id', 'safe', 'on'=>'search'),
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
			'domain_id' => 'Domain',
			'server' => 'Server',
			'product' => 'Product',
			'price' => 'Price',
			'expires_date' => 'Expires Date',
			'start_date' => 'Start Date',
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
		$criteria->compare('domain_id',$this->domain_id,true);
		$criteria->compare('server',$this->server,true);
		$criteria->compare('product',$this->product,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('expires_date',$this->expires_date,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('contact_id',$this->contact_id,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}