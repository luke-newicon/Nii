<?php

/**
 * Description of HftContactSources
 *
 * @author robinwilliams
 */
class HftContactClassification extends NActiveRecord {
	
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
		return 'contact_classification';
	}
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => 'pk',
				'name' => "varchar(255) NOT NULL",
			),
			'keys' => array(array('name')),
		);
	}
	
	public static function getClassificationsArray() {
		$model = new HftContactClassification;
		$classification = $model->findAll(array('order'=>'name'));
		$classifications = array();
		
		foreach ($classification as $s) {
			$classifications[$s->id] = $s->name;
		}
		
		return $classifications;
	}
	
	public static function getClassificationsForGridFilter() {
		return CMap::mergeArray(array('0'=>'--none--'), HftContactClassification::getClassificationsArray());
	}
	
}