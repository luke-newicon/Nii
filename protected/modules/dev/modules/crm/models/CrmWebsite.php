<?php

/**
 * This is the model class for table "nworx_crm__website".
 *
 * The followings are the available columns in table 'nworx_crm__website':
 * @property string $id
 * @property string $address
 * @property string $label
 * @property string $contact_id
 */
class CrmWebsite extends CrmActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CrmWebsite the static model class
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
		return '{{crm_website}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('address, contact_id', 'required'),
			array('address, label', 'length', 'max'=>250),
			array('contact_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, address, label, contact_id', 'safe', 'on'=>'search'),
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
			'contact'=>array(self::BELONGS_TO, 'CrmContact', 'contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'address' => 'Address',
			'label' => 'Label',
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
		$criteria->compare('address',$this->address,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('contact_id',$this->contact_id,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getWebsiteLabels(){
		return self::getLabels(__CLASS__,array(
			'Website'=>array('title'=>'Enter a web address'),
			'Facebook'=>array('title'=>'Enter a Facebook profile address e.g. "http://www.facebook.com/markzuckerberg"'),
			'LinkedIn'=>array('title'=>'Enter a Linkedin profile address like "http://www.linkedin.com/in/profilename" or "http://www.linkedin.com/compnay/newicon"'),
			'Twitter'=>array('title'=>'Enter a twitter username e.g. "newicon"'),
			'Blog'=>array('title'=>'')
		));
	}
	
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}

	public function schema(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'contact_id'=>'int',
				'address'=>'string',
				'label'=>'string',
			),
			'keys'=>array(
				array('contact_id')
			),
			'foreignKeys'=>array(
				array('crm_website_contact', 'contact_id', 'crm_contact', 'id', 'CASCADE', 'CASCADE')
			)
		);
	}
	
}