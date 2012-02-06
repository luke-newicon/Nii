<?php
/**
 * Nii class file.
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link https://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
class ProjectModule extends NWebModule
{

	
	public $name = 'Projects';
	public $description = 'Project management module';
	public $version = '0.0.1';
	
	public function init(){
		Yii::import('project.models.*');
	}
	
	public function setup(){
		Yii::app()->menus->addItem('main', 'Projects', array('/project/index'), null, array(
			'visible' => Yii::app()->user->checkAccess('menu-tasks'),
		));
		Yii::app()->menus->addItem('main', 'Tasks', array('/project/task'), null, array(
			'visible' => Yii::app()->user->checkAccess('menu-tasks'),
		));
		
		Yii::app()->sprite->addImageFolderPath(Yii::getPathOfAlias('project.images'));
		
		Yii::app()->urlManager->addRules(array(
				array('/project/task/index',   'pattern'=>'api/project/<pid:\d+>/task',			 'verb'=>'GET',),
				array('/project/task/create', 'pattern'=>'api/project/<pid:\d+>/task',          'verb'=>'POST'),
				array('/project/task/view',   'pattern'=>'api/project/<pid:\d+>/task/<id:\w+>', 'verb'=>'GET'),
				array('/project/task/update', 'pattern'=>'api/project/<pid:\d+>/task/<id:\w+>', 'verb'=>'PUT'),
				array('/project/task/delete', 'pattern'=>'api/project/<pid:\d+>/task/<id:\w+>', 'verb'=>'DELETE'),	
			)
		);
		
	}
	
	public function install(){
		ProjectProject::install();
		ProjectTask::install();
		ProjectTaskUser::install();
		$this->installPermissions();
	}
	
	public function uninstall(){
		//NActiveRecord::uninstall('TaskTask');
	}
	
	public function activate(){
		
	}
	
	public function deactivate(){
		
	}
	
	public function menus(){
		
	}
	
	public function notifications(){
		
	}

	
	public function permissions() {
		return array(
			'task' => array('description' => 'Tasks',
				'tasks' => array(
					'view' => array('description' => 'View Tasks',
						'roles' => array('administrator','editor','viewer'),
						'operations' => array(
							'task/admin/tasks',
							'task/admin/viewTask',
							'menu-tasks',
						),
					),
					'manage' => array('description' => 'Add/Edit/Delete Tasks',
						'roles' => array('administrator','editor'),
						'operations' => array(
							'task/admin/addTask',
							'task/admin/editTask',
							'task/admin/deleteTask',
						),
					),
				),
			),
		);
	}
	
	
	/**
	 * gets a list of all projects
	 * 
	 * @return array ProjectProject
	 */
	public function getProjectList(){
		return ProjectProject::model()->findAll();
	}
	
	/**
	 * Create a task for a project
	 * 
	 * @param mixed $project ProjectProject or project id
	 * @param array $taskAttributes array of task attributes
	 * return int id of the created task
	 */
	public function createTask($project, $taskAttributes){
		$pid = ($project instanceof ProjectProject) ? $project->id : $project;
		$t = new ProjectTask;
		$t->project_id = $pid;
		$t->attributes = $taskAttributes;
		$t->save();
		return $t->id;
	}

	/**
	 * get an array of tasks
	 * 
	 * @return array of task models 
	 */
	public function getTaskList($condition=''){
		return ProjectTask::model()->findAll($condition);
	}
	
}