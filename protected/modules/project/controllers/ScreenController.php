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
	/**
	 * store the NMarkdown object
	 * @var NMarkdown 
	 */
	public $markdown;
	
	/**
	 * store the current screen object
	 * @var ProjectScreen
	 */
	public $screen;
	
	public function init(){
		Yii::app()->getClientScript()->registerCoreScript('bbq');
	}

	/**
	 * render the individual screen view
	 * @param int $id 
	 */
	public function actionIndex($id){
		
		$this->layout = 'index';
		$screen = $this->loadScreen($id);
		$screen = ProjectScreen::model()->findByPk($id);
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
	 * @param ProjectScreen $screen
	 * @return array 
	 */
	public function getCommentsData($screen){
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
	 * @return string 
	 */
	public function getCommentsJson($screen){
		return json_encode($this->getCommentsData($screen));
	}
	
	
	/**
	 * ajax: adds a new template
	 */
	public function actionAddTemplate(){
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
	 * ajax: applies a template to a screen
	 * expects: 
	 * template: id of the template to apply
	 * screen: id of the screen to apply to
	 */
	public function actionApplyTemplate(){
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
	
	
	public function actionRemoveTemplate(){
		$tid = $_POST['template'];
		$sid = $_POST['screen'];
		$t = ProjectScreenTemplate::model()->findByPk(array('template_id'=>$tid,'screen_id'=>$sid));
		$t->delete();
	}
	
	public function actionAddTemplateSpot(){
		$sid = $_POST['spot'];
		$tid = $_POST['template'];
		$s = ProjectHotSpot::model()->findByPk($sid);
		$s->template_id = $tid;
		// unlink from the screen as its now a template??
		$s->save();
	}
	
	public function actionSaveComment(){
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
		echo json_encode(array('id'=>$c->id,'comment'=>$comment));
	}
	
	public function actionDeleteComment(){
		$c = ProjectComment::model()->findByPk($_POST['id']); 
		$c->delete();
	}
	
	public function actionDeleteTemplate(){
		$id = $_POST['id'];
		$t = ProjectTemplate::model()->findByPk($id);
		if($t===null)
			throw new CHttpException(404,'no template found');
		$success = $t->delete();
		
		echo json_encode(array('result'=>array('success'=>true)));
	}

	/**
	 *
	 * @return NMarkdown 
	 */
	public function getMarkdown(){
		if($this->markdown===null){
			$this->markdown = new NMarkdown;
		}
		return $this->markdown;				
	}
	
	/**
	 * load in a new screen to edit by ajax
	 */
	public function actionLoad(){
		$screen = $this->loadScreen($_REQUEST['id']);
		echo json_encode(array(
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
	 * @param string $h hash 
	 */
	public function actionView($h){
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

	
	public function getProjectScreenData($project, &$hotspotData){
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
	
	public function validPassword($link){
		if(!isset($_POST['password']) || $_POST['password']=='')
			return false;
		if($link->password == $link->password)
			return true;
	}
	
	
	/**
	 * returns the screen object
	 * @param int $id
	 * @return ProjectScreen or null 
	 */
	public function loadScreen($id){
		if($this->screen === null)
			$this->screen = ProjectScreen::model()->findByPk($id);
		if($this->screen === null)
			throw new CHttpException(404, 'whoops, no screen found');
		return $this->screen;
	}
	
	/**
	 * generate a new link
	 */
	public function actionProjectLink(){
		$pl = new ProjectLink;
		$pl->attributes = $_POST['ProjectLink'];
		$pl->save();
		echo $this->renderPartial('_share-form-item',array('link'=>$pl));
	}
	
	/**
	 * Deletes a project link
	 */
	public function actionDeleteLink(){
		// maybe this should only soft delete?
		$pl = ProjectLink::model()->findByPk($_POST['id']);
		if($pl===null)
			throw new CHttpException (404, 'No project link found');
		$pl->delete();
	}
	
}