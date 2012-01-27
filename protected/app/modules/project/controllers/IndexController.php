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

	/**
	 *	Grid view - for now - of the open projects 
	 */
	public function actionIndex() {
		
		$modelName = 'ProjectProject';
	
		$model = new $modelName('search');
		$model->unsetAttributes();
		
		if(isset($_GET[$modelName]))
			$model->attributes = $_GET[$modelName];

		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
	}
	
	public function actionView($id) {
				
		$this->pageTitle = Yii::app()->name . ' - View Project Details';
		
		$modelName = 'ProjectProject';
		$model = NActiveRecord::model($modelName)->findByPk($id);
		
		$this->checkModelExists($model, "<strong>No project exists for ID: ".$id."</strong>");
		
		$viewData = array(
			'model'=>$model,
		);
		
		$this->render('view',array(
			'model'=>$model,
		));
	}
	
	public function actionTasks($id) {
		$this->render('tabs/tasks');
	}
	
	public function actionMilestones($id) {
		$this->render('tabs/milestones');
	}
	
	public function actionFiles($id) {
		$model = NActiveRecord::model('ProjectProject')->findByPk($id);
				
		$viewData = array(
			'model'=>$model,
		);
		
		$this->render('tabs/files',array(
			'model'=>$model,
		));
	
	}
	
}