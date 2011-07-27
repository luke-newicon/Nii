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
class Project extends NAppRecord
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
	
	public function relations(){
		return array(
			'comments'=>array(self::HAS_MANY, 'ProjectComment', 'project_id'),
		);
	}
	
	/**
	 * get all project screens
	 * @return array of ProjectScreen
	 */
	public function getScreens(){
		return ProjectScreen::model()->findAllByAttributes(array('project_id'=>$this->id),array('order'=>'sort ASC'));
	}
	
	
	/**
	 * return all of the generated project links
	 */
	public function getLinks(){
		return ProjectLink::model()->findAllByAttributes(array('project_id'=>$this->id));
	}
	
	
	/**
	 * gets the title image from the screens
	 * typically selects the home page or the first screen
	 */
	public function getImageId(){
		$screen = ProjectScreen::model()->find('project_id=:id AND home_page = 1',array('id'=>$this->id));
		if($screen===null)
			$screen = ProjectScreen::model()->find(array('condition'=>'project_id=:id','params'=>array('id'=>$this->id),'order'=>'sort ASC'));
		if($screen===null)
			return -99;
		return $screen->file_id;
	}
	
	/**
	 * Get the total number of comments this project has
	 * 
	 * @return integer 
	 */
	public function getNumComments(){
		$screens = array();
		foreach($this->getScreens() as $s)
			$screens[] = $s->id;
		return ProjectComment::model()->countByAttributes(array('screen_id'=>$screens));
	}
	
	/**
	 * get the total number of screens this project has
	 * @return integer
	 */
	public function getNumScreens(){
		return ProjectScreen::model()->countByAttributes(array('project_id'=>$this->id));
	}
	
	/**
	 * get a list of project screens,
	 * this is used to populate the javascript array for the autocomplete screen selection
	 * @return array 
	 */
	public function getScreenList(){
		$screenList = array();
		foreach($this->getScreens() as $i=>$s){
			$screenList[] = array(
				'value'=>$s->id,
				'label'=>$s->name, // get transformed into html by search
				'name'=>$s->name,
				'src'=>NHtml::urlImageThumb($s->file_id, 'project-drop-down-48-crop'),
				'bigSrc'=>NHtml::urlFile($s->file_id, $s->name)
			);
		}
		return $screenList;
	}
	
	
	/**
	 * populate a select box with all the projects screens
	 * @return array 
	 */
	public function getScreensListData($notSelected='- Select linking image -'){
		$arr = array(0=>$notSelected);
		$ret = CHtml::listData($this->getScreens(), 'id', 'name');
		return $arr + $ret ;
	}
	
	/**
	 * get the start screen for the preview.
	 */
	public function getHomeScreen(){
		$screen = ProjectScreen::model()->findByAttributes(array('project_id'=>$this->id,'sort'=>0));
		if($screen===null)
			throw new CHtppException(404, 'Oops I couldn\'t find the home screen');
		return $screen;
	}
	
}