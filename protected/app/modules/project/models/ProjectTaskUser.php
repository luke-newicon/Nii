<?php

class ProjectTaskUser extends NActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{project_task_user}}';
	}

	public function rules() {
		return array(
			array('name', 'required'),
			array('description, priority, importance, created_by_id, assigned_id, estimated_time', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'id' => 'Task Number',
			'name' => 'Task Title',
			'description' => 'Description',
			'priority' => 'Priority',
			'importance' => 'Importance',
			'estimated_time' => 'Estimated Time',
			'assigned_id' => 'Owner',
			'project_id' => 'Project',
			'customer_id' => 'Customer',
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'project' => array(self::BELONGS_TO, 'ProjectProject', 'project_id'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->getDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('priority', $this->priority, true);
		$criteria->compare('importance', $this->importance, true);

		return new NActiveDataProvider('ProjectTask', array(
			'criteria' => $criteria,
		));
	}
	
	public function editLink($text=null){
		if(!$text)
			$text = $this->name;
		return CHtml::link($text, array('/task/admin/editTask','id'=>$this->id()));
	}
	

	public static function install($className=__CLASS__) {
		parent::install($className);
	}

	public function schema() {
		return array(
			'columns' => array(
				'task_id' => 'int',
				'user_id' => 'int',
				'type' => "enum('staff','customer','notified')",
			),
		);
	}
	
	public function getCustomer_name(){
		if($this->customer)
			return $this->customer->name;
	}
	
	public function getProject_name(){
		if($this->project)
			return $this->project->name;
	}

	public function projectList(){
		return CHtml::listData(TaskProject::model()->findAll(), 'id', 'name');
	}
	
	public function customerList(){
		return CHtml::listData(ContactCustomer::model()->findAll(), 'id', 'name');
	}
	
}