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
class ProjectLink extends NActiveRecord
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
		return '{{project_link}}';
	}
	
	public function rules(){
		return array(
			array('link,project_id,password','safe')
		);
	}
	
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema(){
		return array(
			'columns'=>array(
				'link'=>'string',
				'project_id'=>'int',
				'password'=>'text',
				0=>'PRIMARY KEY (`link`)'
			),
			'keys'=>array(
				array('project_id'),
			)
		);
	}
	
	public function beforeSave(){
		parent::beforeSave();
		$rnd = rand(10, 10000);
		$string = $this->project_id . '' . 'somerandom!@-!stro!g'.$rnd;
		//TODO: check there is no collision
		$this->link = sprintf('%x',crc32($string));
		return true;
	}
	
	
	
}