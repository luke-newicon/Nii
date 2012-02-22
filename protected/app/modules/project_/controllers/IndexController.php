<?php
/**
 * Project index controller class file.
 *
 * @link http://newicon.net/nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/nii/license/
 */

/**
 * Description of Project
 *
 * @author steve
 * @package nii.project
 */
class IndexController extends AController 
{
	
	public function accessRules() {
		return array(
			array('allow',
				'users' => array('@'),
			),
			array('deny', // deny all users
				'users' => array('?'),
			),
		);
	}

	public function rules(){
		return array(
			array('name','required')
		);
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
	
	
	
	/**
	 * Create a new project
	 */
	public function actionCreate() {
		// todo validate project name is unique
		
		$modelName = 'ProjectProject';
		
		$model = new $modelName;
		$this->performAjaxValidation($model, 'createproject');
		
		if ($_POST[$modelName]) {
			$model->attributes = $_POST[$modelName];
			$model->save();
		}
		
		// after creating a project we redirect to the project index page
		$this->redirect(array('/project/details/index', 'id'=>$model->id));
	}
	
	public function actionCreateJob($projectId) {
		$modelName = 'ProjectTask';
		
		$model = new $modelName;
		$this->performAjaxValidation($model, 'createJob');
		if ($_POST[$modelName]) {
			$model->project_id = $projectId;
			$model->attributes = $_POST[$modelName];
			$model->addNodeToRoot($model);
		}
		$this->redirect(array('/project/details/index', 'id'=>$model->id));
	}
	
	public function actionDocs(){
		$this->render('docs');
	}
	
}