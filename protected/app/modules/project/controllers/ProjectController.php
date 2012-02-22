<?php

/**
 * ProjectController class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of ProjectController
 *
 * @author steve
 */
class ProjectController extends AController
{
	/**
	 * displays a project details view
	 * @param mixed $project string project name key or id of the project
	 */
	public function actionIndex($project)
	{
		$p = $this->loadProject($project);
		$this->render('index',array('project'=>$p));
	}

	/**
	 *
	 * @param mixed $project string project name or int pk
	 */
	public function actionCreateJob($project)
	{
		$this->performAjaxValidation(new ProjectTask, 'create-job');
		$p = $this->loadProject($project);
		ProjectApi::createJob($p->id, $_POST['ProjectTask']);
	}
	
	/**
	 * Load a project
	 * @param type $project
	 * @throws CHttPException if project not found
	 * @return ProjectTask 
	 */
	public function loadProject($project)
	{
		$p = ProjectApi::loadProject($project);
		if($p===null)
			throw new CHttpException (404, 'Oops, This is not the project you are looking for.');
		return $p;
	}
}