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
 * Description of DetailsController
 *
 * @author steve
 */
class ScreenController extends AController 
{
	
	public $layout = 'index';
	
	
	/**
	 * store the current project object
	 * 
	 * @see self::loadProject
	 * @var Project 
	 */
	public $project;
	
	public function init() {
		// needed for old screen
		Yii::app()->getClientScript()->registerCoreScript('bbq');
	}

	
	/**
	 * Load the Project model
	 * 
	 * @param int $id 
	 * @return Project
	 */
	public function loadProject($id) {
		if($this->project === null)
			$this->project = Project::model()->findByPk($id);
		if($this->project === null)
			throw new CHttpException(404, 'whoops, no project found');
		return $this->project;
	}
	

	/**
	 * Hotspot is only using this one controller action now!
	 * Draws the main project edit screen
	 */
	public function actionScreen($project) {

		$project = $this->loadProject($project);
		
		$hotspotArray = array_merge($project->getHotspotsArray(),$project->getTemplateHotspots());
		
		//$hotspotArray = ProjectHotSpot::model()->findAllByAttributes(array('project_id'=>$project->id));
		
		Yii::beginProfile('json encode');
		$arr = array(
			'project'				=> $project,
			'projectJson'			=> CJSON::encode($project), // not used at the moment
			'screensJson'			=> CJSON::encode($project->getScreens()),
			'hotspotsJson'			=> CJSON::encode($hotspotArray),
			'templatesJson'			=> CJSON::encode($project->getTemplates()),
			'screenTemplatesJson'	=> CJSON::encode($project->getAppliedTemplates()),
			'linkJson'				=> CJSON::encode($project->getLink()),
		);
		Yii::endProfile('json encode');
		
		
		$this->render('screen',$arr);
		
	}
	
	
	/**
	 * saves the order of project screens after being sorted
	 */
	public function actionOrder() {
		$order = $_POST['order'];
		//$sql = 'UPDATE project_screen SET `order` = CASE `id` ';
		
		$keys = array();
		$sql = '';
		foreach($order as $key=>$val){
			$sql .= "WHEN $key THEN $val ";
			$keys[] = $key;
		}
		//$sql .= 'END WHERE id IN ('.implode(',',$keys).')';
		ProjectScreen::model()->updateByPk($keys, 
			array('sort' => new CDbExpression("CASE id $sql END"))
		);
	}
	
	/**
	 * Delete a screenTemplate removing the template from the screen
	 */
	public function actionDeleteScreenTemplate(){
		ProjectScreenTemplate::model()->deleteByPk(array(
			'template_id'=>$_POST['template_id'],
			'screen_id'=>$_POST['screen_id']
		));
        
	}
	
}