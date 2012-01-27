<?php

class ProjectTask extends NActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{project_task}}';
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
			'finish_date' => 'Finish Date',
			'owner' => 'Owner',
			'project_name' => 'Project',
			'customer_name' => 'Customer',
			'project_id' => 'Project',
			'customer_id' => 'Customer',
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'customer' => array(self::BELONGS_TO, 'ContactCustomer', 'customer_id'),
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
	
	public function viewLink($text=null){
		if(!$text)
			$text = $this->name;
		return CHtml::link($text, array('/task/admin/viewTask','id'=>$this->id()));
	}
	
	public function viewProject(){
		if($this->project)
			return $this->project->viewLink();
	}
	
	public function viewCustomer(){
		if($this->customer)
			return $this->customer->viewLink();
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
				'priority' => 'int',
				'created_by_id' => 'int',
				'estimated_time' => 'int',
				'assigned_id' => 'int',
				'customer_id' => 'int',
				'project_id' => 'int',
				'status' => "enum('new','current','complete)",
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
	
	
	public function behaviors() {
		return array(
			'tree'=>array(
               'class'=>'nii.components.behaviors.NTreeTable'
           )
		);
	}
	
}