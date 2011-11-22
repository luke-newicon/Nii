<?php

class TaskItemChild extends NActiveRecord {

	public function tableName() {
		return '{{task_item_child}}';
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
				'parent' => 'int not null',
				'child' => 'int not null',
				0 => 'PRIMARY KEY (parent,child)',
			),
			'foreignKeys' => array(
				array('task_parent', 'parent', '{{task_item}}', 'id', 'CASCADE', 'CASCADE'),
				array('task_child', 'child', '{{task_item}}', 'id', 'CASCADE', 'CASCADE'),
			)
		);
	}

}