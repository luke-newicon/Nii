<?php

/**
 * Template class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of Template
 *
 * @author steve
 */
class ProjectTemplate extends NActiveRecord
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
		return '{{project_template}}';
	}
	
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'project_id'=>'int',
				'name'=>'string',
			),
			'keys'=>array(
				array('project_id')
			),
			'foreignKeys'=>array(
				array('project_template','project_id','project_project','id','CASCADE','CASCADE')
			)
		);
	}
	
	/**
	 * checks if the template is active for this screen
	 * 
	 * @param int $screenId the id of the screen
	 * @return boolean 
	 */
	public function isAppliedTo($screenId){
		// a bit of an expensive function as it is called for every template
		// however for speed of development should not be a problem as long as people have less than a hundred or so templates.
		// this is called for each template in the project. On every screen loaded in edit mode
		$t = ProjectScreenTemplate::model()->findByAttributes(array('screen_id'=>$screenId,'template_id'=>$this->id));
		return ($t===null)?false:true;
	}
	
	
	
}