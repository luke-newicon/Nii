<?php

/**
 * This is the model class for table "nworx_crm__phone".
 *
 * The followings are the available columns in table 'nworx_crm__phone':
 * @property string $id
 * @property string $number
 * @property string $label
 * @property string $contact_id
 * @property string $verified
 */
class CrmPhone extends CrmActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CrmPhone the static model class
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
		return '{{nii_crm__phone}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number, contact_id', 'required'),
			array('number, label', 'length', 'max'=>250),
			array('contact_id', 'length', 'max'=>11),
			array('verified', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, number, label, contact_id, verified', 'safe', 'on'=>'search'),
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
			'number' => 'Number',
			'label' => 'Label',
			'contact_id' => 'Contact',
			'verified' => 'Verified',
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
		$criteria->compare('number',$this->number,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('contact_id',$this->contact_id,true);
		$criteria->compare('verified',$this->verified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

}