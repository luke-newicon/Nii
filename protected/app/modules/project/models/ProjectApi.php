<?php

/**
 * ProjectApi class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of ProjectApi
 *
 * @author steve
 */
class ProjectApi extends CComponent
{
	/**
	 * create a new top level project
	 * @param array $projectAttributes 
	 */
	public static function createProject($projectAttributes)
	{
		$project = new ProjectTask();
		
		$project->attributes = $projectAttributes;
		$project->type = ProjectTask::TYPE_PROJECT;
		if($project->save()){
			$project->addNodeToRoot($project);
		}
		return $project;
	}
}