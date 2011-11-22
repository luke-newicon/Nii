<?php

class TaskAssignment extends NActiveRecord {

	public function tableName() {
		return '{{task_assignment}}';
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
				'itemid' => 'varchar(64) not null',
				'userid' => 'varchar(64) not null',
				'type' => 'varchar(64) not null',
				0 => 'PRIMARY KEY (itemid,userid,type)',
			),
		);
	}

}