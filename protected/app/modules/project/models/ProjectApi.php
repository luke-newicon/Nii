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
	 * @return ProjectTask
	 */
	public static function createProject($projectAttributes)
	{
		$project = new ProjectTask();
		
		$project->attributes = $projectAttributes;
		$project->type = ProjectTask::TYPE_PROJECT;
		if($project->validate()){
			$project->addNodeToRoot($project);
		}
		return $project;
	}
	
	/**
	 * create a new top level job
	 * @param int $projectId the project to add the job to
	 * @param array $projectAttributes 
	 * @return ProjectTask
	 */
	public static function createJob($projectId, $jobAttributes)
	{
		$job = new ProjectTask();
		
		$job->attributes = $jobAttributes;
		$job->type = ProjectTask::TYPE_JOB;
		if($job->validate()){
			$p = ProjectTask::model()->findByPk($projectId);
			$p->addChild($job);
		}
		return $job;
	}
}