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
	
	public $markdown;
	/**
	 * render the individual screen view
	 * @param int $id 
	 */
	public function actionIndex($id){
		
		$this->layout = 'index';
		
		$screen = ProjectScreen::model()->findByPk($id);
		$project = Project::model()->findByPk($screen->project_id);
		if($screen===null) throw new CHttpException (404,'whoops, no screen found');
		
		$file = $screen->getFile();
		if($file===null) throw new CHttpException (404,'whoops, no screen found');
		
		$rgb = $screen->guessBackgroundColor();
		$info = getimagesize($file->getPath());
		
		// get all the hotspots on the screen
		$hotspots = ProjectHotSpot::model()->findAllByAttributes(array('screen_id'=>$screen->id,'template_id'=>0));
		$templateSpots = $screen->getTemplateHotspots();
		$comments = ProjectComment::model()->findAllByAttributes(array('screen_id'=>$screen->id));
		$this->render('screen',array(
			'project'=>$project,
			'screen'=>$screen,
			'file'=>$file,
			'width'=>$info[0],
			'height'=>$info[1],
			'rgb'=>$rgb,
			'hotspots'=>$hotspots,
			'comments'=>$comments,
			'templateHotspots'=>$templateSpots
		));
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
	
	
	
}