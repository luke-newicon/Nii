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
	
	
	
	/**
	 * the preview mode must recieve the hash
	 * @param string $h hash 
	 */
	public function actionIndex($h){
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
			$this->render('/screen/view',array(
				'project'=>$project, 
				'screen'=>$screen,
				'rgb'=>$screen->guessBackgroundColor(),
				'screenData'=>json_encode($screenData),
				'screenDataSize'=>count($screenData),
				'hotspotData'=>json_encode($hotspotData),
			));
		}else{
			$this->render('/screen/password',array('project'=>$project, 'screen'=>$screen));
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
	
	
}