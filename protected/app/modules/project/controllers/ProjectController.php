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
		// if integer assume id
		if(is_int(is_numeric($project))){
			$p = ProjectTask::model()->projects()->findByPk($project);
		} else {
			$p = ProjectTask::model()->projects()->findByAttributes(array('name'=>$project));
		}
		echo " project is: " . $p->name;
	}
}