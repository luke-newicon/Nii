<?php

class TestExtra extends LActiveRecord {
	
	public $comments2 = 'Hello2';

	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{test_extra}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comments, number','required'),
			array('comments, number, comments2', 'safe'),
		);
	}
	
	public function numberData(){
		return array(
			1=>'Apple',
			2=>'Bear',
			3=>'Cat',
			4=>'Dot',
			5=>'Elephant',
		);
	}
	
	public function definitions() {
		return array(
			'number' => array(LAttributeType::ENUM, 'data' => '$data->numberData()'),
			'comments' => array(LAttributeType::TEXT),
		);
	}

	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'comments' => "varchar(255)",
			),
			'keys' => array());
	}

}