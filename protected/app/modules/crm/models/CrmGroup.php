<?php
/**
 * @property id
 * @property name
 */
Class CrmGroup extends NAppRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CrmEmail the static model class
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
		return '{{crm_group}}';
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
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
		$criteria->compare('name',$this->contact_id,true);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}

	public function schema(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'name'=>'string',
			),
			'keys'=>array(
				array('name')
			),
		);
	}
}