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
		$projects = Project::model()->findAll(array('order'=>'id DESC'));
		$this->render('index',array('projects'=>$projects));
	}
	
	public function actionInstall(){
		ProjectModule::get()->install();
	}
	
	public function actionCreate(){
		$p = new Project;
		$name = $_POST['name'];
		// todo: duplicate name check here?
		$p->name = $name;
		$p->save();
		$pStamp = $this->render('_project-stamp',array('project'=>$p), true);
		echo json_encode(array(
			'id'=>$p->id,
			'project'=>$pStamp
		));
	}
	
	public function actionDelete(){
		$p = Project::model()->findByPk($_POST['id']);
		if($p===null)
			throw new CHttpException(404,'Can not find the specified project');
		$p->delete();
	}
	
}