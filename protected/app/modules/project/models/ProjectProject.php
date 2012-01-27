<?php

class ProjectProject extends NActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{project_project}}';
	}

	public function rules() {
		return array(
			array('name', 'required'),
			array('code, description, customer_id, assigned_by_id', 'safe'),
			array('id, name, description, customer_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
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
		return CHtml::link($text, array('/project/index', 'id'=>$this->id()));
	}

	public static function install($className=__CLASS__) {
		parent::install($className);
	}

	public function schema() {
		return array(
			'columns' => array(
				'id' => 'pk',
				'name' => 'string',
				'description' => 'text',
				'created_by_id' => 'int',
				'customer_id' => 'int',
				'assigned_id' => 'int',
				'tree_left' => 'int',
				'tree_right' => 'int',
				'tree_level' => 'int',
				'tree_parent' => 'int',
			),
		);
	}
	
	public static function projectList(){
		return CHtml::listData(self::model()->findAll(), 'id', 'name');
	}
	
	public function behaviors() {
		return array(
			'tree'=>array(
               'class'=>'nii.components.behaviors.NTreeTable'
           )
		);
	}

}