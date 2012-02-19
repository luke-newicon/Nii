<?php

/**
 * ProjectTask class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of ProjectTask
 *
 * @author steve
 */
class ProjectTask extends NActiveRecord
{
	
	const TYPE_PROJECT = 'PROJECT';
	const TYPE_TASK = 'TASK';
	const TYPE_JOB = 'JOB';
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function behaviors() 
	{
		return array(
			'tree'=>array(
				'class'=>'nii.components.behaviors.NTreeTable'
			),
			'timestampable'=>array(
				'class'=>'nii.components.behaviors.NTimestampable'
			)
		);
	}
	
	public function rules()
	{
		return array(
			array('name','required'),
			// project names must be unique
			array('name', 'unique', 'criteria'=>array('condition'=>'tree_level=1')),
			array('billable_time, due, estimated_time','safe')
		);
	}

	
	public function scopes() 
	{
		return array(
			'projects'=>array(
				'condition'=>'type=:type',
				'params'=>array(':type'=>self::TYPE_PROJECT)
			),
			'jobs'=>array(
				'condition'=>'type=:type',
				'params'=>array(':type'=>self::TYPE_JOB)
			),
			'tasks'=>array(
				'condition'=>'type=:type',
				'params'=>array(':type'=>self::TYPE_TASK)
			),
		);
	}
	
	public function schema() 
	{
		return array(
			'columns' => array(
				'id' => 'pk',
				'name' => 'string',
				'name_slug'=>'string',
				'description' => 'text',
				'priority' => 'int',
				'assigned_id' => 'int',
				'customer_id' => 'int',
				'workflow_id' => "int",
				'type'=>"enum('".self::TYPE_PROJECT."','".self::TYPE_JOB."','".self::TYPE_TASK."')",
				'due'=>'datetime',
				// estimated time in minutes
				'estimated_time'=>'int',
				// billable time in minutes
				'billable_time'=>'int',
			),
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() 
	{
		$criteria = $this->getDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('description', $this->description, true);

		return new NActiveDataProvider('ProjectTask', array(
			'criteria' => $criteria,
		));
	}
	
	/**
	 * get the URI for the record
	 * @return string 
	 */
	public function getLink()
	{
		if($this->type == self::TYPE_PROJECT)
			return NHtml::url(array('/project/project/index', 'project'=>$this->name_slug));
		$parent = $this->getParent();
		return NHtml::url(array('/project/task/index','project'=>$parent->name_slug, 'id'=>$this->id));
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function beforeSave()
	{
		if(!isset($this->name_slug))
			$this->name_slug = NHtml::urlize($this->name);
		return parent::beforeSave();
	}
	
}