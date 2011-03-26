<?php

class TaskController extends NAController {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		return array(
			array('allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('index', 'view'),
				'users' => array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('create', 'update','taskList'),
				'users' => array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('admin', 'delete'),
				'users' => array('@'),
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * The task card and associated time record information.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		// Code used by the search function
		$taskRecord= new ProjectTimeRecord('search');
		$taskRecord->unsetAttributes();  // clear any default values
		if(isset($_GET['ProjectTimeRecord']))
			$taskRecord->attributes= $_GET['ProjectTimeRecord'];

		//Gets the time overiview stats for the task.
		$taskTimeOverview = $taskRecord->timeOverviewTimeType($id);

		$this->render('view', array(
			'model' => $this->loadModel($id),
			'ProjectTimeRecord'=>$taskRecord,
			'taskTimeOverview'=>$taskTimeOverview
		));
	}

	/**
	 * Adds a new task. This will either show the create a new task
	 * or if no data is present then display the creation form.
	 * @param int $projectId The if of the project which the new task should be linked to.
	 */
	public function actionCreate($projectId) {
		$model = new ProjectTask;
		$model->project_id = $projectId;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		//Save the new task
		if (isset($_POST['ProjectTask'])) {
			$model->attributes = $_POST['ProjectTask'];
			$model->created_by = yii::app()->getUser()->getId();

			if ($model->save())
				$this->redirect(array('index/view', 'id' => $model->project_id));
		}

		//If not saving then renders the create form.
		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if (isset($_POST['ProjectTask'])) {
			$model->attributes = $_POST['ProjectTask'];
			if ($model->save())
				$this->redirect(array('index/view', 'id' => $model->project_id));
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(array('index/index'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('ProjectTask');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin() {
		$model = new ProjectTask('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['ProjectTask']))
			$model->attributes = $_GET['ProjectTask'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = ProjectTask::model()->findByPk((int) $id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'project-task-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actiontaskList(){
	    $this->renderPartial('_grid',);
	}

}
