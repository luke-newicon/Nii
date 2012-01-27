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
class TaskController extends AController {

	public function actionCreate($task) {
		// todo validate project name is unique
		$t = new ProjectTask();
		$t->name = $task;
		$t->save();
		$this->redirect(array('/project/task', 'id' => $t->id()));
	}

	public function actionIndex() {
		
		$allTasks = NActiveRecord::model('ProjectTask')->findAll();
		$tasks = CJSON::encode($allTasks);
		$this->render('index', array('tasks'=>$tasks));
	}

}