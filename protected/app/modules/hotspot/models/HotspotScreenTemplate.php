<?php

/**
 * Project class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of Project
 *
 * @author steve
 */
class HotspotScreenTemplate extends NAppRecord
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProjectProject the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function rules(){
		return array(
			array('template_id, screen_id', 'safe')
		);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{hotspot_screen_template}}';
	}
	
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	
	public function schema(){
		return array(
			'columns'=>array(
				'template_id'=>'int',
				'screen_id'=>'int',
				0=>'PRIMARY KEY (`template_id`, `screen_id`)'
			),
//			'foreignKeys'=>array(
//				array('project_screen_template','template_id','project_template','id','CASCADE','CASCADE'),
//			)
		);
	}
	
	protected function beforeSave(){
		// don't save if the template id is zero!
		if($this->template_id == '0')
			return false;
		
		return parent::beforeSave();
	}
}