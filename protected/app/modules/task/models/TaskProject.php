<?php

class TaskProject extends NActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{task_project}}';
	}

	public function rules() {
		return array(
			array('name', 'required'),
			array('code, description, customer_id', 'safe'),
			array('id, code, name, description, customer_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'name' => 'Name',
			'description' => 'Description',
			'customer_id' => 'Customer',
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array();
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria = $this->getDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('code', $this->code, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('customer_id', $this->customer_id, true);

		return new NActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	
	public function viewLink($text=null){
		if(!$text)
			$text = $this->name;
		return CHtml::link($text, array('/task/project/index', 'id'=>$this->id()));
	}

	public static function install($className=__CLASS__) {
		parent::install($className);
	}

	public function schema() {
		return array(
			'columns' => array(
				'id' => 'pk',
				'code' => 'string',
				'name' => 'string',
				'description' => 'text',
				'customer_id' => 'int',
			),
		);
	}
	
	public static function projectList(){
		return CHtml::listData(self::model()->findAll(), 'id', 'name');
	}

}