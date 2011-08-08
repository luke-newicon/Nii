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
class ProjectTemplate extends NAppRecord
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
				array('project_template','project_id','project_project','id','CASCADE','CASCADE'),
			)
		);
	}
	
	/**
	 * used by self::isAppliedTo function
	 * stores an array of screen ids to an array of applied template ids
	 * each time isAppliedTo is called it checks if the screen id exists as a key 
	 * if it does not then it queries the screen object for an aray of the applied 
	 * template ids and stores it against the scren id key simples.
	 * for example:
	 * [1]=>array(
	 *     [0]=>1
	 *     [1]=>3
	 * )
	 * this indicates that screen with id of 1 has two templates applied with ids of 1 and 3
	 * .simples.
	 * @var array
	 * @see ProjectTemplate::isAppliedTo
	 */
	public $screenTemplates = array();
	
	/**
	 * checks if the template is active for this screen
	 * 
	 * @param ProjectScreen $screen the screen object
	 * @return boolean 
	 */
	public function isAppliedTo($screen){
		if(!array_key_exists($screen->id, $this->screenTemplates))
			$this->screenTemplates[$screen->id] = $screen->getTemplatesAppliedIds();
		// get array of applied template ids for this screen
		$appliedTs = $this->screenTemplates[$screen->id];
		// lets check if the current template ($this) is in the array
		return in_array($this->id, $appliedTs);
	}
	
	
	
}