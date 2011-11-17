<?php

/**
 * Description of HftEventOrganiserType
 *
 * @author robinwilliams
 */
class HftEventOrganiserType extends NActiveRecord {
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hft_event_organiser_type';
	}
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => 'pk',
				'name' => "varchar(255) NOT NULL",
				'display_order' => 'int(11)',
			),
			'keys' => array(),
		);
	}
	
	public static function getTypesArray() {
		$model = new HftEventOrganiserType;
		$type = $model->findAll();
		$types = array();
		
		foreach ($type as $t) {
			$types[$t->id] = $t->name;
		}
		
		return $types;
	}
	
}