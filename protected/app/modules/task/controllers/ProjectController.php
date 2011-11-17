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
class ProjectController extends AController
{
	
	public function actionCreate($project){
		// todo validate project name is unique
		$p = new TaskProject();
		$p->name = $project;
		$p->save();
		$this->redirect(array('/task/project/index', 'projectId'=>$p->id));
	}
	
	public function actionIndex($projectId){
		$p = TaskProject::model()->findByPk($projectId);
		if($p === null)
			throw new CHttpException ('Oops no project exists here');
		
		$this->render('index', array('project'=>$p));
	}
}