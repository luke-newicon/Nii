<?php

/**
 * IndexController class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of IndexController
 *
 * @author steve
 */
class IndexController extends AController
{
	
	public function actionIndex()
	{
		$this->render('index',array('taskSearch'=>ProjectTask::model()->searchModel()));
	}
	
	/**
	 * create a new top level project  
	 */
	public function actionCreateProject()
	{
		$this->performAjaxValidation(new ProjectTask, 'create-project');
		$project = ProjectApi::createProject($_POST['ProjectTask']);
		$this->redirect(array('/project/project/index','project'=>$project->name_slug));
	}
	
}