<?php

/**
 * IndexCrontroller class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of IndexCrontroller
 *
 * @author steve
 */
class IndexController extends AController
{ 
	//put your code here
	public function actionIndex(){
		$this->layout = 'index';
		$projects = HotspotProject::model()->findAll(array('order'=>'id DESC'));
		
		$this->render('index',array('projects'=>$projects));
	}
	
	public function actionInstall(){
		HotspotModule::get()->install();
	}
	
	public function actionCreate(){
		$p = new Project;
		$name = $_POST['name'];
		// todo: duplicate name check here?
		$p->name = $name;
		$success = $p->save();
		
		$ret = array();
		if(!$success){
			// the name attribute is used to store general errors for the project
			$ret['error'] = $p->getErrors('name');
		}
		
		$ret['result'] = array(
			'id'=>$p->id,
			'project'=>$this->render('_project-stamp',array('project'=>$p), true)
		);
				
		echo json_encode($ret);
		Yii::app()->end();
	}
	
	public function actionDelete(){
		$p = HotspotProject::model()->findByPk($_POST['id']);
		if($p===null)
			throw new CHttpException(404,'Can not find the specified project');
		$p->delete();
	}
	
	
	/**
	 * ajax action called when a user updates his plan
	 * This action is responsible for redrawing the project create, and project upgrade box.
	 * for example after upgrading to a higher plan we should redraw and redisplay the create project box
	 */
	public function actionPlanChange(){
		$plan = Yii::app()->user->account->plan;
		$projectCount = HotspotProject::model()->count();
		$ret = array('result'=>array(
			'html'=>$this->renderPartial('_project-upgrade', array(), true),
			'canCreateProject'=>!($plan['projects'] == $projectCount),
			'user_trial'=>Yii::app()->user->InTrial()
		));
		echo CJSON::encode($ret);
	}
	
	/**
	 * action called by ajax when the show-this-window-on-hotspot-open checkbox is changed
	 * @param string $show true | false whether the hotspot help window should show when the user logs in.
	 */
	public function actionHelpWindow($show){
		Yii::app()->user->settings->set('show-help-window', (($show=='true')?true:false));
	}
	
	/**
	 * action called by ajax when the show-this-window-on-hotspot-open checkbox is changed
	 * @param string $show true | false whether the hotspot help window should show when the user logs in.
	 */
	public function actionGetHelpWindow(){
		echo Yii::app()->user->settings->get('show-help-window');
		Yii::app()->end();
	}
	
}