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
class OldController extends AController 
{
	/**
	 * store the NMarkdown object
	 * 
	 * @var NMarkdown 
	 */
	public $markdown;
	
	public $layout = 'index';
	
	/**
	 * store the current screen object
	 * 
	 * @see self::loadScreen
	 * @var ProjectScreen
	 */
	public $screen;
	
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
	 * old screen
	 * render the individual screen view
	 * 
	 * @param int $id 
	 */
	public function actionIndex($project) {
		
		$project = $this->loadProject($project);
		$screen = $project->getStartScreen();
		$project = Project::model()->findByPk($screen->project_id);
		
		
		// get all the hotspots on the screen
		$this->render('screen',array(
			'project'=>$project,
			'screen'=>$screen,
			'file'=>$screen->getFile(),
			'width'=>$screen->getWidth(),
			'height'=>$screen->getHeight(),
			'rgb'=>$screen->guessBackgroundColor(),
			'hotspots'=>$screen->getHotspots(),
			'comments'=>$screen->getComments(),
			'templateHotspots'=>$screen->getTemplateHotspots(),
		));
	}
	
	/**
	 * generates the comments json array data.
	 * This enables the javascript to manipulate the comments on the screen index page
	 * 
	 * @param ProjectScreen $screen
	 * @return array 
	 */
	public function getCommentsData($screen) {
		$commentJson = array();
		foreach($screen->getComments() as $comment){
			$commentJson[$comment->id] = array(
				'comment'=>$comment->comment,
				'view'=>$this->renderPartial('_comment',array('comment'=>$comment),true)
			);
		}
		return $commentJson;
	}
	
	/**
	 * json_encoded comments data for javascript
	 * 
	 * @return string 
	 */
	public function getCommentsJson($screen) {
		return json_encode($this->getCommentsData($screen));
	}
	
	
	/**
	 * ajax: adds a new template
	 */
	public function actionAddTemplate() {
		$pid = $_POST['project'];
		$template = $_POST['template'];
		$t = new ProjectTemplate();
		$t->name = $template;
		$t->project_id = $pid;
		$t->save();
		
		$itemInfo = $this->renderPartial('_template-item', array('template'=>$t), true);
		echo json_encode(array('template_id'=>$t->id,'item'=>$itemInfo));
	}
	
	/**
	 * 
	 */
	public function actionRenameTemplate() {
		$tid = $_POST['id'];
		$t = ProjectTemplate::model()->findByPk($tid);
		if($t===null)
			throw new CHttpException(404,'Can not find template');
		$t->name = $_POST['name'];
		$t->save();
	}
	
	/**
	 * ajax: applies a template to a screen
	 * expects: 
	 * template: id of the template to apply
	 * screen: id of the screen to apply to
	 */
	public function actionApplyTemplate() {
		$tid = $_POST['template'];
		$st = new ProjectScreenTemplate();
		$st->template_id = $tid;
		$st->screen_id = $_POST['screen'];
		$st->save();
		// need to get template hotspot info.
		$hotspotRecords = ProjectHotSpot::model()->findAllByAttributes(array('template_id'=>$tid));
		$hotspots = array();
		foreach($hotspotRecords as $hs){
			$hotspots[] = $hs->getAttributes();
		}
		echo json_encode($hotspots);
	}
	
	public function actionRemoveTemplate() {
		$tid = $_POST['template'];
		$sid = $_POST['screen'];
		$t = ProjectScreenTemplate::model()->findByPk(array('template_id'=>$tid,'screen_id'=>$sid));
		$t->delete();
	}
	
	public function actionAddTemplateSpot() {
		$sid = $_POST['spot'];
		$tid = $_POST['template'];
		$s = ProjectHotSpot::model()->findByPk($sid);
		$s->template_id = $tid;
		$s->screen_id = 0;
		$s->save();
	}
	
	public function actionSaveComment() {
		$comment = $_POST['comment'];
		$sid = $_POST['screen'];
		if($_POST['id'] == 0) 
			$c = new ProjectComment;
		else
			$c = ProjectComment::model()->findByPk($_POST['id']);
		$c->comment = $comment;
		$c->screen_id = $sid;
		$c->left = $_POST['left'];
		$c->top = $_POST['top'];
		$c->username = Yii::app()->user->getName();
		$c->email = Yii::app()->user->email;
		$c->save();
		$comment = $this->renderPartial('_comment',array('comment'=>$c),true);
		echo json_encode(array('id'=>$c->id,'comment'=>$comment,'data'=>$c->getAttributes()));
	}
	
	public function actionDeleteComment() {
		$c = ProjectComment::model()->findByPk($_POST['id']); 
		$c->delete();
	}
	
	public function actionDeleteTemplate() {
		$id = $_POST['id'];
		$t = ProjectTemplate::model()->findByPk($id);
		if($t===null)
			throw new CHttpException(404,'no template found');
		$success = $t->delete();
		// delete all of the hotspots in this template
		ProjectHotSpot::model()->deleteAllByAttributes(array('template_id'=>$id));
		echo json_encode(array('result'=>array('success'=>true)));
	}

	/**
	 *
	 * @return NMarkdown 
	 */
	public function getMarkdown() {
		if($this->markdown===null){
			$this->markdown = new NMarkdown;
		}
		return $this->markdown;				
	}
	
	/**
	 * load in a new screen to edit by ajax
	 */
	public function actionLoad() {
		$screen = $this->loadScreen($_REQUEST['id']);
		echo json_encode(array(
			'name'=>$screen->name,
			'canvas'=>$this->renderPartial('_canvas',array('screen'=>$screen),true),
			'commentsJson'=>$this->getCommentsData($screen),
			'bgRgb'=>$screen->guessBackgroundColor(),
			'templates'=>$screen->getTemplatesAppliedIds(),
			'size'=>$screen->getSize(),
			'hotspots'=>$this->renderPartial('_hotspots',array('screen'=>$screen, 'onlyLinked'=>true),true),
		));
	}
	
	/**
	 * the preview mode must receve the hash
	 * 
	 * @param string $h hash 
	 */
	public function actionView($h) {
		$this->layout = 'index';
		$link = ProjectLink::model()->findByPk($h);
		if($link===null)
			throw new CHttpException(404, 'Oops this page does not exist');
		
		$project = Project::model()->findByPk($link->project_id);
		if($project===null)
			throw new CHttpException(404, 'Oops this project no loger exists');

		$screen = $project->getHomeScreen();
		
		if($link->password == '' || $this->validPassword($link)){
			$screenData = $this->getProjectScreenData($project, $hotspotData);
			$this->render('view',array(
				'project'=>$project, 
				'screen'=>$screen,
				'rgb'=>$screen->guessBackgroundColor(),
				'screenData'=>json_encode($screenData),
				'screenDataSize'=>count($screenData),
				'hotspotData'=>json_encode($hotspotData),
			));
		}else{
			$this->render('password',array('project'=>$project, 'screen'=>$screen));
		}
	}

	
	public function getProjectScreenData($project, &$hotspotData) {
		$screenList = array();
		$hotspotData=array();
		foreach($project->getScreens() as $i=>$s){
			$screenHotspots = array();
			foreach($s->getHotspots(true) as $hs){
				$screenHotspots[$hs->id] = 1;
				$hotspotData[$hs->id] = $hs->getAttributes();
			}
			foreach($s->getTemplateHotspots(true) as $hs){
				$screenHotspots[$hs->id] = 1;
				$hotspotData[$hs->id] = $hs->getAttributes();
			}
			$screenList[$s->id] = array(
				'id'=>$s->id,
				'name'=>$s->name,
				'rgb'=>$s->guessBackgroundColor(),
				'src'=>NHtml::urlFile($s->file_id, $s->name),
				'screenHotspots'=>array_keys($screenHotspots),
				//'hotspots'=>$this->renderPartial('_hotspots',array('screen'=>$s),true)
			);
		}
		
		return $screenList;
	}
	
	public function validPassword($link) {
		if(!isset($_POST['password']) || $_POST['password']=='')
			return false;
		if($link->password == $link->password)
			return true;
	}
	
	/**
	 * Load the Project model
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
	 * returns the screen object
	 * @param int $id
	 * @return ProjectScreen or null 
	 */
	public function loadScreen($id) {
		if($this->screen === null)
			$this->screen = ProjectScreen::model()->findByPk($id);
		if($this->screen === null)
			throw new CHttpException(404, 'whoops, no screen found');
		return $this->screen;
	}
	
	/**
	 * generate a new link
	 */
	public function actionProjectLink() {
		$data = $_POST['ProjectLink'];
		$pl = ProjectLink::model()->findByPk($data['link']);
		if($pl===null)
			throw new CHttpException(404,'Can not find the project link');
		$pl->attributes = $data;
		$pl->save();
	}
	
	/**
	 * Deletes a project link
	 */
	public function actionDeleteLink() {
		// maybe this should only soft delete?
		$pl = ProjectLink::model()->findByPk($_POST['id']);
		if($pl===null)
			throw new CHttpException (404, 'No project link found');
		$pl->delete();
	}
	
	/**
	 * Hotspot is only using this one controller action now!
	 * Draws the main project edit screen
	 */
	public function actionScreen($project) {
		$cs = Yii::app()->getClientScript();
		$url = Yii::app()->getModule('dev')->getAssetsUrl();
		$cs->registerScriptFile("$url/backbone/test/vendor/json2.js");
		$cs->registerScriptFile("$url/backbone/test/vendor/underscore-1.1.6.js");
		$cs->registerScriptFile("$url/backbone/backbone.js");

		$project = $this->loadProject($project);
		
		
		$screenArray = $project->getScreensArray();
		$hotspotArray = $project->getHotspotsArray();
		
		
		
		$templates = ProjectTemplate::model()->findAllByAttributes(array('project_id'=>$project->id()));
		
		Yii::beginProfile('json encode');
		
		// get all the hotspots on the screen
		
		$arr = array(
			'project'=>$project,
			'screensJson'	=> CJSON::encode($screenArray),
			'hotspotsJson'	=> CJSON::encode($hotspotArray),
			'templatesJson'	=> CJSON::encode(NData::toAttrArray($templates)),
			'projectJson'	=> CJSON::encode($project->getAttributes())
			//	'templateHotspots'=>$screen->getTemplateHotspots(),
		);
		Yii::endProfile('json encode');
		
		
		$this->render('screen',$arr);
		
	}
	
	
	/**
	 * ...and using this one
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
	
}