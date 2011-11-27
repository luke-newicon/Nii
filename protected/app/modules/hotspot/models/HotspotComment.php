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
class HotspotComment extends NAppRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProjectProject the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{project_comment}}';
	}
	
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'project_id'=>'int',
				'screen_id'=>'int',
				'comment'=>'text',
				'left'=>'int',
				'top'=>'int',
				'time'=>'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
				'username'=>'text',
				'email'=>'text'
			),
			'keys'=>array(
				array('screen_id')
			),
//			array('project_comment','screen_id','project_screen','id','CASCADE','CASCADE'),
		);
	}
	
	
}