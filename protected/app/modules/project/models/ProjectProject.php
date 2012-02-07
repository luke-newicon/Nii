<?php

/**
 * ProjectProject class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of ProjectProject
 *
 * @author steve
 */
class ProjectProject extends NActiveRecord
{
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
			array('description, created_by_id, assigned_id, customer_id', 'safe'),
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

		return new NActiveDataProvider('ProjectProject', array(
			'criteria' => $criteria,
		));
	}
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'id' => 'Project Number',
			'name' => 'Project',
			'description' => 'Description',
			'created_by_id' => 'Created By',
			'assigned_id' => 'Owner',
			'customer_id' => 'Customer',
		);
	}
	
	public function viewLink(){
		return '<a href="'.NHtml::url(array('/project/details/index', 'id'=>$this->id())).'">' . $this->name . '</a>';
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
				'assigned_id' => 'int',
				'customer_id' => 'int',
			),
		);
	}
	
	
	public function countProjectTasks(){
		return 0;
	}
	
}