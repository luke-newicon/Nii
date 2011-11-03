<?php

class TaskTask extends NActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{task_task}}';
	}

	public function rules() {
		return array(
			array('name', 'required'),
			array('description, priority, importance, finish_date, owner', 'safe'),
			array('id, name, description, priority, importance, finish_date, owner', 'safe', 'on' => 'search'),
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
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->getDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('priority', $this->priority, true);
		$criteria->compare('importance', $this->importance, true);
		$criteria->compare('finish_date', $this->finish_date, true);
		$criteria->compare('owner', $this->owner, true);

		return new NActiveDataProvider('TaskTask', array(
			'criteria' => $criteria,
		));
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
				'importance' => 'int',
				'finish_date' => 'date',
				'owner' => 'string',
			),
		);
	}

}