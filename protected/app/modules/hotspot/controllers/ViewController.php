<?php

/**
 * ViewController class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * The view controller is responsible for displaying the preview experience to the user
 * As this is an area for non-logged in users it is isolated to make it easier to maintain and to make sure
 * potentially unsecure operations are not accidently granted.
 *
 * @author steve
 */
class ViewController extends NController {
	
	
	public function init(){
		Yii::app()->getClientScript()->registerCoreScript('bbq');
	}
	/**
	 * the preview mode must recieve the hash
	 * @param string $h hash 
	 */
	public function actionIndex($h){
		
		$h = substr($h, 1, strlen($h));
		$this->layout = 'view';
		$link = $this->loadLink($h);
		
		$project = HotspotProject::model()->findByPk($link->project_id);
		if($project===null)
			throw new CHttpException(404, 'Oops this project no loger exists');

		$this->pageTitle = $project->name;
		
		$screen = $project->getStartScreen();
		
		if($link->password == '' || $this->validPassword($link)){
			$screenData = $this->getProjectScreenData($project, $hotspotData);
			$this->render('/screen/view',array(
				'project'=>$project, 
				'screen'=>$screen,
				'rgb'=>$screen->guessBackgroundColor(),
				'screenData'=>json_encode($screenData),
				'screenDataSize'=>count($screenData),
				'hotspotData'=>json_encode($hotspotData),
				'hash'=>$h
			));
		}else{
			$this->render('/screen/password',array('project'=>$project, 'screen'=>$screen));
		}
	}
	
	public $markdown;
	
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
	
	public function getComments($screen){
		$commentJson = array();
		foreach($screen->getComments() as $comment){
			$commentJson[$comment->id] = array(
				'data'=>$comment->getAttributes(),
				'comment'=>$comment->comment,
				'view'=>$this->renderPartial('/screen/_comment',array('comment'=>$comment),true)
			);
		}
		return $commentJson;
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
				'comments'=>$this->getComments($s)
				//'hotspots'=>$this->renderPartial('_hotspots',array('screen'=>$s),true)
			);
		}
		
		return $screenList;
	}
	
	public function validPassword($link){
		if(!isset($_POST['password']) || $_POST['password']=='')
			return false;
		return ($link->password == $_POST['password']);
	}
	
	
	/**
	 * Saves a comment on the view page
	 */
	public function actionSaveComment(){
		$link = $this->loadLink($_POST['hash']);
		
		$comment = $_POST['comment'];
		$sid = $_POST['screen'];
		if($_POST['id'] == 0) 
			$c = new ProjectComment;
		else
			$c = HotspotComment::model()->findByPk($_POST['id']);
		$c->comment = $comment;
		$c->screen_id = $sid;
		$c->left = $_POST['left'];
		$c->top = $_POST['top'];
		$c->username = $_POST['name'];
		$c->email = $_POST['email'];
		$c->save();
		$comment = $this->renderPartial('/screen/_comment',array('comment'=>$c),true);
		echo json_encode(array('id'=>$c->id,'comment'=>$comment,'data'=>$c->getAttributes()));
	}
	
	/**
	 * Loads the ProjectLink with the hash
	 * Also check for page validity
	 * 
	 * @param string $h the hash
	 */
	public function loadLink($h)
	{
		$link = ProjectLink::model()->findByPk($h);
		if($link===null)
			throw new CHttpException('Ooops this page no loger exists.');
		return $link;
	}
	
	
	/**
	 * Delete a comment from the view
	 */
	public function actionDeleteComment(){
		$link = $this->loadLink($_POST['hash']);
		$com = HotspotComment::model()->findByPk($_POST['id']);
		// bit of a quick check (not really secure, but who cares)
		$ret = false;
		if($com->email == $_POST['email'])
			$ret = $com->delete();
		return json_encode(array('success'=>$ret));
	}
	
	
}