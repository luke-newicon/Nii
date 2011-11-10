<?php

/**
 * {name} class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of HotspotHotspots
 *
 * @author steve
 */
class HotspotHotspot extends NAppRecord 
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
			array('screen_id,project_id,width,height,left,top,screen_id_link,fixed_scroll,template_id','safe')
		);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{project_hotspot}}';
	}
	
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema(){
		
		return array(
			'columns'=>array(
				'id'=>'pk',
				'screen_id'=>'int',
				'project_id'=>'int',
				'template_id'=>'int NULL DEFAULT \'0\'',
				'width'=>'int',
				'height'=>'int',
				'left'=>'int',
				'top'=>'int',
				'screen_id_link'=>'int NULL DEFAULT \'0\'',
				'fixed_scroll'=>'TINYINT(1) NULL DEFAULT  \'0\''
			),
			'keys'=>array(
				array('template_id'),
				array('screen_id'),
				array('screen_id_link'),
				array('project_id'),
			),
		);
	}
	
}
