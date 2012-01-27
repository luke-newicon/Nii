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
class IndexController extends AController {

	public function actionCreate($project) {
		// todo validate project name is unique
		$p = new ProjectProject();
		$p->name = $project;
		$p->save();
		$this->redirect(array('/project/index', 'id' => $p->id()));
	}

	public function actionIndex() {
		$allProjects= NActiveRecord::model('ProjectProject')->findAll();
		$projects = CJSON::encode($allProjects);
		$this->render('index', array('projects'=>$projects));
	}

}