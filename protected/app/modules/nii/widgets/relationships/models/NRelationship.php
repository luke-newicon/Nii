<?php

/**
 * This is the model class for table "trinity.relationship".
 *
 * The followings are the available columns in table 'trinity.relationship':
 * @property integer $contact_id
 * @property string $relationship
 * @property integer $relationship_id
 */
class NRelationship extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Relationship the static model class
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
		return '{{nii_relationship}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contact_id, model, model_id', 'required'),
			array('contact_id, model_id', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('contact_id, model, model_id, label, type', 'safe'),
			array('contact_id, model, model_id, label, type', 'safe', 'on'=>'search'),
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
			'contact_id' => 'Name',
			'model' => 'Model',
			'model_id' => 'Related',
			'label' => 'Relation (e.g. Spouse, Manager)',
			'type' => 'Type',
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

		$criteria->compare('contact_id',$this->contact_id);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('model_id',$this->model_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}