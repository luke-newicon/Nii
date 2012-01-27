<?php

class ProjectProject extends NActiveRecord {

	public $countTasks;
	
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
			'countTasks' => '# Tasks',
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'customer' => array(self::BELONGS_TO, 'ContactCustomer', 'customer_id'),
		);
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
	
	public function columns() {
		
		return array(
			array(
				'name' => 'id',
				'htmlOptions'=>array('width'=>'30px'),
			),
			array(
				'name' => 'name',
				'type' => 'raw',
				'value' => '$data->viewLink()',
			),
			array(
				'name' => 'customer_id',
				'type' => 'raw',
				'value' => '$data->customerLink',
				'exportValue' => '$data->customerName',
			),
			array(
				'name' => 'countTasks',
				'type' => 'raw',
				'value' => '$data->countProjectTasks()',
				'htmlOptions'=>array('width'=>'30px'),
			),
			array(
				'name' => 'editLink',
				'type' => 'raw',
				'value' => '$data->editLink',
				'filter' => false,
				'sortable' => false,
				'htmlOptions'=>array('width'=>'30px'),
				'export'=>false,
			),
		);
	}
	
	public function viewLink($text=null){
		if(!$text)
			$text = $this->name;
		return CHtml::link($text, array('/project/index/view', 'id'=>$this->id()));
	}
	
		
	public function getCustomerName(){
		if($this->customer)
			return $this->customer->name;
		else
			return '<span class="noData">No customer assigned</span>';
	}
	
	public function getCustomerLink(){
		if($this->customer)
			return NHtml::link($this->customer->name, array('/contact/admin/view', 'id'=>$this->customer->id()));
		else
			return '<span class="noData">No customer assigned</a>';
	}
	
	public function getEditLink() {
		if ($this->id)
			return NHtml::link('Edit', array('/project/index/edit', 'id'=>$this->id));
	}
	
	public function countProjectTasks($status=array('new','current')) {
		if (is_array($status))
			$condition = '`status` IN ("'.implode ('","', $status).'")';
		else
			$condition = '`status` = "'.$status.'"';
		return NActiveRecord::model('ProjectTask')->countByAttributes(array('project_id'=>$this->id), $condition);
	}
	
	public function getProjectTasks($status=array('new','current')) {
		if (is_array($status))
			$condition = '`status` IN ("'.implode ('","', $status).'")';
		else
			$condition = '`status` = "'.$status.'"';
		$tasks = NActiveRecord::model('ProjectTask')->findByAttributes(array('project_id'=>$this->id), $condition);
		return NHtml::listData($tasks, 'id', 'name');
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