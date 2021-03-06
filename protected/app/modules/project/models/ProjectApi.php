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
			if($p===null)
				throw new CException('The parent project was not found');
			$p->addChild($job);
		}
		return $job;
	}
	
	/**
	 * create a new task under $parentId
	 * @param int $parentId id of parent project, job or task
	 * @param array $taskAtrributes
	 * @return ProjectTask 
	 */
	public function createTask($parentId, $taskAtrributes)
	{
		$task = new ProjectTask();
		
		$task->attributes = $taskAtrributes;
		$task->type = ProjectTask::TYPE_TASK;
		if($task->validate()){
			$parent = ProjectTask::model()->findByPk($parentId);
			if($parent===null)
				throw new CException('The parent task was not found');
			$parent->addChild($task);
		}
		return $task;
	}
	
	/**
	 * Load a project
	 * @param mixed $project string (project name slug) id project pk
	 * @return ProjectTask | null
	 */
	public function loadProject($project)
	{
		// if integer assume id
		if(is_numeric($project))
			$p = ProjectTask::model()->projects()->findByPk($project);
		else
			$p = ProjectTask::model()->projects()->findByAttributes(array('name_slug'=>$project));
		return $p;
	}
}