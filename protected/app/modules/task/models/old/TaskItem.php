<?php

class TaskItem extends NActiveRecord {
	const TYPE_ACTION=0;
	const TYPE_TASK=1;
	const TYPE_PROJECT=2;

	public function tableName() {
		return '{{task_item}}';
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public static function install($className=__CLASS__) {
		parent::install($className);
	}

	public function schema() {
		return array(
			'columns' => array(
				'id' => 'pk',
				'type' => 'int not null',
				'number' => 'varchar(64) not null',
				'name' => 'string',
				'description' => 'text',
				'priority' => 'varchar(64)',
				'importance' => 'varchar(64)',
				'finish_date' => 'date',
				'estimate' => 'varchar(64)',
			),
		);
	}

}