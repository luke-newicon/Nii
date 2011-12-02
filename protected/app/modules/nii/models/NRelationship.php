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
			array('contact_id, relationship, relationship_id', 'required'),
			array('contact_id, relationship_id', 'numerical', 'integerOnly'=>true),
			array('relationship', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('contact_id, relationship, relationship_id', 'safe', 'on'=>'search'),
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
			'contact_id' => 'Contact',
			'relationship' => 'Relationship',
			'relationship_id' => 'Relationship',
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

		$criteria->compare('contact_id',$this->contact_id);
		$criteria->compare('relationship',$this->relationship,true);
		$criteria->compare('relationship_id',$this->relationship_id);

		return new NActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'contact_id' => "int(11) NOT NULL",
				'model' => "varchar(255) NOT NULL",
				'model_id' => "int(11) NOT NULL",
				'label' => "varchar(255)",
				'type' => "varchar(255)",
				'trashed' => "int(1) unsigned NOT NULL",
			),
			'keys' => array(
				array('person_idx','contact_id'),
				array('contact','contact_id,model_id'),
			),
		);
	}
	
	public static function countRelationships($model, $model_id) {
		return self::model()->countByAttributes(array('model'=>$model, 'model_id'=>$model_id));
	}
	
}