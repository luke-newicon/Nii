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
			array('description, priority, created_by_id, assigned_id, estimated_time, project_id', 'safe'),
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
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'project' => array(self::BELONGS_TO, 'ProjectProject', 'project_id'),
			'customer' => array(self::BELONGS_TO, 'ContactCustomer', 'customer_id'),
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
	
	public function editLink($text=null){
		if(!$text)
			$text = $this->name;
		return CHtml::link($text, array('/project/task/edit','id'=>$this->id()));
	}
	
	public function viewLink($text=null){
		if(!$text)
			$text = $this->name;
		return CHtml::link($text, array('/project/task/view','id'=>$this->id()));
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
				'tree_left' => 'int',
				'tree_right' => 'int',
				'tree_level' => 'int',
				'tree_parent' => 'int',
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
		return CHtml::listData(ProjectProject::model()->findAll(), 'id', 'name');
	}
	
	public function customerList(){
		return CHtml::listData(ContactCustomer::model()->findAll(), 'id', 'name');
	}
	
	/**
	 *	Returns the estimated time from the database in a readable format
	 * @param int $time
	 * @param string $length - 'long' or 'short'
	 * @return string 
	 */
	public static function getEstimatedTime($time, $length='long') {
		
		if ($time >= 450) :
			$time = $time/450;
			$granularity = $length=='long' ? (' day' . ($time>1?'s':'')) : 'd';
		elseif ($time >= 60) :
			$time = $time/60;
			$granularity = $length=='long' ? (' hour' . ($time>1?'s':'')) : 'h';
		else :
			$granularity = $length=='long' ? (' min' . ($time>1?'s':'')) : 'm';
		endif;
			
		return number_format($time,(strstr($time, '.')?1:0)) . $granularity;
	}

	/**
	 *	Takes a string and returns the estimated time in integer of minutes format
	 * Also checks to see if the string is actually just numerical
	 * @param string $string - '1d', '2 hours' etc
	 * @return int 
	 */
	public static function setEstimatedTime($string, $default='h') {
		
		if (ctype_digit($string)) {
			$number = $string;
			$alpha = $default;
		} else {				
			// split string into number + alpha
			$splitResults=array();
			preg_match("/(\d+)(.+)$/",$string,$splitResults);
			$number = $splitResults[1];
			$alpha = str_replace(' ', '', $splitResults[2]);
		}
		
		switch($alpha) {
			
			case "d":
			case "day":
			case "days":
				$time = $number * 450;
				break;
			
			case "h":
			case "hour":
			case "hours":
				$time = $number * 60;
				break;
			
			default :
				$time = $number;
			
		}

		return $time;		
	}
	
	public function behaviors() {
		return array(
			'tree'=>array(
               'class'=>'nii.components.behaviors.NTreeTable'
           )
		);
	}
	
}