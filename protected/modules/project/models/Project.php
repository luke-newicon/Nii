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
class Project extends NActiveRecord
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
		return '{{project_project}}';
	}
	
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'name'=>'string',
				'description'=>'text'
			)
		);
	}
	
	/**
	 * get all project screens
	 * @return array of ProjectScreen
	 */
	public function getScreens(){
		return ProjectScreen::model()->findAllByAttributes(array('project_id'=>$this->id));
	}
	
	public function getScreensListData(){
		$arr = array(0=>'- Select Linking Image -');
		$ret = CHtml::listData($this->getScreens(), 'id', 'name');
		return $arr + $ret ;
	}
	
	/**
	 * gets the title image from the screens
	 * typically selects the home page or the first screen
	 */
	public function getImageId(){
		$screen = ProjectScreen::model()->find('project_id=:id AND home_page = 1',array('id'=>$this->id));
		if($screen===null)
			$screen = ProjectScreen::model()->find('project_id=:id',array('id'=>$this->id));
		if($screen===null)
			return -99;
		return $screen->file_id;
	}
	
}