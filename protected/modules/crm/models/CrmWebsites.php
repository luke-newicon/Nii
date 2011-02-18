<?php

/**
 * This is the model class for table "pm__nworx_crm_websites".
 *
 * The followings are the available columns in table 'pm__nworx_crm_websites':
 * @property string $website_id
 * @property string $website_address
 * @property string $website_label
 * @property string $website_contact_id
 *
 * The followings are the available model relations:
 * @property PmNworxCrmContacts $websiteContact
 */
class CrmWebsites extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CrmWebsites the static model class
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
		return 'pm__nworx_crm_websites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('website_address, website_label, website_contact_id', 'required'),
			array('website_address, website_label', 'length', 'max'=>250),
			array('website_contact_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('website_id, website_address, website_label, website_contact_id', 'safe', 'on'=>'search'),
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
			'websiteContact' => array(self::BELONGS_TO, 'PmNworxCrmContacts', 'website_contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'website_id' => 'Website',
			'website_address' => 'Website Address',
			'website_label' => 'Website Label',
			'website_contact_id' => 'Website Contact',
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

		$criteria->compare('website_id',$this->website_id,true);
		$criteria->compare('website_address',$this->website_address,true);
		$criteria->compare('website_label',$this->website_label,true);
		$criteria->compare('website_contact_id',$this->website_contact_id,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}