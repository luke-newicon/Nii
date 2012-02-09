<?php

class ProjectTask extends NActiveRecord {

	
	const STATUS_NEW = 'new';
	const STATUS_CURRENT = 'current';
	const STATUS_COMPLETE = 'complete';
	
	public $estimated_time_nice;
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
			array('description, priority, created_by_id, assigned_id, estimated_time, estimated_time_nice, project_id', 'safe'),
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
			'estimated_time' => 'Estimated Time',
			'assigned_id' => 'Owner',
			'project_id' => 'Project',
			'customer_id' => 'Customer',
			'type'=>'Type'
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

		return new NActiveDataProvider('ProjectTask', array(
			'criteria' => $criteria,
		));
	}

	
	public function viewProject(){
		if($this->project)
			return $this->project->viewLink();
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
				'status' => "enum('new','current','complete')",
			),
		);
	}
	

	public function projectList(){
		return CHtml::listData(ProjectProject::model()->findAll(), 'id', 'name');
	}

	
	
	
	public function getAdditionalUsers($displayIcon=true) {
		$users = NActiveRecord::model('ProjectTaskUser')->findByAttributes(array('task_id'=>$this->id));
		$u = array();

		if ($users) {
			foreach($users as $user)
				$u[$id] = $user->getUserLink($displayIcon);
		}
		
		return $u;
	}
	
//	public function behaviors() {
//		return array(
//			'tree'=>array(
//               'class'=>'nii.components.behaviors.NTreeTable'
//           )
//		);
//	}
	
}