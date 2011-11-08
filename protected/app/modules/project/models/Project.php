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
		return parent::install($className);
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
	
	public function rules(){
		return array(
			// use the name attribute to store the error
			array('name', 'plan')
		);
	}
	
	/**
	 * validation rule to ensure you do not exceed the plan project limit
	 * @param type $attribute
	 * @param type $params 
	 */
	public function plan($attribute,$params){
		$count = $this->count();
		$plan = Yii::app()->user->getPlan();
		if($plan['projects'] == 'unlimited')
			return;
		if($count >= $plan['projects']){
			$this->addError('name', 'duplicate name');
			$this->addError('name', 'you have reached your plan\'s project limit');
		}
	}
	
	public function relations(){
		return array(
			'comments'=>array(self::HAS_MANY, 'ProjectComment', 'project_id'),
		);
	}
	
	/**
	 * cache result from getScreens
	 */
	private $_screens=array();
	
	/**
	 * get all project screens
	 * @return array of ProjectScreen
	 */
	public function getScreens(){
		if(empty($this->_screens))
			$this->_screens = ProjectScreen::model()->findAllByAttributes(array('project_id'=>$this->id),array('order'=>'sort ASC'));
		return $this->_screens;
	}
	
	/**
	 * instance cache of screenIds array
	 * @var type 
	 */
	private $_screenIds = array();
	
	/**
	 * return an array of all screen ids
	 * @return array of screen ids
	 */
	public function getScreensIdArray(){
		if(empty($this->_screenIds)){
			$this->_screenIds = array();
			foreach($this->getScreens() as $s)
				$this->_screenIds[] = $s->id;
		}
		return $this->_screenIds;
	}
	
	
	
	/**
	 * gets all applied templates for each screan in the project
	 * 
	 * @return array of ProjectScreenTemplate objects
	 */
	public function getAppliedTemplates(){
		$screenIds = $this->getScreensIdArray();
		return ProjectScreenTemplate::model()->findAllByAttributes(array('screen_id'=>$screenIds));
	}
	
	/**
	 * get all templates available to this project
	 * 
	 * @return array of ProjectTemplate active record models
	 */
	public function getTemplates(){
		return ProjectTemplate::model()->findAllByAttributes(array('project_id'=>$this->id));
		
	}
	
	
	/**
	 * returns all hotspots across all screens for this project
	 * 
	 * NOTE: Does not include template hotspots! And SHOULD NOT! template hotspots must be available to the project,
	 * and should not be discovered through specifc screens, as if these screens are all deleted you lose the ability 
	 * to access the templates, to get the template hotspots call self::getTemplateHotspots
	 * 
	 * @return array ProjectHotSpot
	 */
	public function getHotspots(){
		return ProjectHotSpot::model()->findAllByAttributes(array('screen_id'=>$this->getScreensIdArray()), 'template_id = 0');
	}
	
	/**
	 * get template hotspots, get all hotspots that are available as templates to this project
	 * 
	 * @return array of ProjectHotSpot template models
	 */
	public function getTemplateHotspots(){
		$ts = array();
		foreach($this->getTemplates() as $k => $v)
			$ts[] = $v->id;
		return ProjectHotSpot::model()->findAllByAttributes(array('template_id'=>$ts));
	}
	
	/**
	 * returns a hotspot attribute array
	 * for use with json
	 * @return array (array hotspot attributes)
	 */
	public function getHotspotsArray(){
		$ret = array();
		foreach($this->getHotspots() as $hs){
			$ret[] = $hs->getAttributes();
		}
		return $ret;
	}
	
	/**
	 * return all of the generated project links
	 */
	public function getLinks(){
		return ProjectLink::model()->findAllByAttributes(array('project_id'=>$this->id));
	}
	
	/**
	 * gets the project share link, if one does not exist it creates one.
	 * @return ProjectLink 
	 */
	public function getLink(){
		$link = ProjectLink::model()->findByAttributes(array('project_id'=>$this->id));
		if($link===null){
			// lets create a new default one.
			$link = new ProjectLink();
			$link->project_id = $this->id;
			$link->save();
		}
		return $link;
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
	
	
	private $_numComments;
	/**
	 * Get the total number of comments this project has
	 * 
	 * @return integer 
	 */
	public function getCommentsCount(){
		if($this->_numComments === null){
			$screens = array();
			foreach($this->getScreens() as $s)
				$screens[] = $s->id;
			$this->_numComments = ProjectComment::model()->countByAttributes(array('screen_id'=>$screens));
		}
		
		return $this->_numComments;
	}
	
	/**
	 * get the total number of screens this project has
	 * @return integer
	 */
	public function getScreensCount(){
		return ProjectScreen::model()->countByAttributes(array('project_id'=>$this->id));
	}
	
	/**
	 * get the total number of hotspots this project has
	 * @return integer
	 */
	public function getHotspotCount(){
		return ProjectHotSpot::model()->countByAttributes(array('project_id'=>$this->id, 'template_id'=>0));
	}
	
	/**
	 * get a list of project screens,
	 * this is used to populate the javascript array for the autocomplete screen selection
	 * 
	 * DEPRICATED!!
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

	
	public $startScreen;
	
	/**
	 * get the start screen for the preview.
	 */
	public function getStartScreen(){
		if($this->startScreen===null){
			$this->startScreen = ProjectScreen::model()->findByAttributes(array('project_id'=>$this->id), array('order'=>'sort ASC'));
			if($this->startScreen===null)
				throw new CHttpException(404, 'Oops I couldn\'t find the home screen');
		}
		return $this->startScreen;
	}
	

	
	public function afterDelete() {
		parent::afterDelete();
		// delete all screens and related project data
		ProjectScreen::model()->deleteScreens($this->id);
		ProjectComment::model()->deleteAllByAttributes(array('project_id'=>$this->id));
		ProjectLink::model()->deleteAllByAttributes(array('project_id'=>$this->id));
	}
	
	
}