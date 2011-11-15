<?php

/**
 * Description of HftContactSources
 *
 * @author robinwilliams
 */
class HftContactSource extends NActiveRecord {
	
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
		return 'contact_source';
	}
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => 'pk',
				'name' => "varchar(255) NOT NULL",
			),
			'keys' => array(),
		);
	}
	
	public static function getSourcesArray() {
		$model = new HftContactSource;
		$source = $model->findAll();
		$sources = array();
		
		foreach ($source as $s) {
			$sources[$s->id] = $s->name;
		}
		
		return $sources;
	}
	
}