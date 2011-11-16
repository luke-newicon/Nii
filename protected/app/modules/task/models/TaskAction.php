<?php

class TaskAction extends NActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{task_action}}';
	}

	public function rules() {
		return array(
			array('action', 'required'),
			array('owner_id', 'safe'),
			array('id, action, owner_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'action' => 'Description',
			'owner_id' => 'Owner',
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
		$criteria->compare('action', $this->description, true);
		$criteria->compare('customer_id', $this->customer_id, true);

		return new NActiveDataProvider($this, array(
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
				'action' => 'text',
				'owner_id' => 'int',
			),
		);
	}

}