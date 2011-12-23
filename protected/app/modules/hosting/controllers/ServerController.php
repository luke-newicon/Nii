<?php

class ServerController extends AController {

	/**
	 * @return array action filters
	 */
//	public function filters()
//	{
//		return array(
//			'accessControl', // perform access control for CRUD operations
//		);
//	}
//
//	/**
//	 * Specifies the access control rules.
//	 * This method is used by the 'accessControl' filter.
//	 * @return array access control rules
//	 */
//	public function accessRules()
//	{
//		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);
//	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->pageTitle = Yii::app()->name . ' - Hosted Servers';
		$modelName = 'HostingServer';
	
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->pageTitle = Yii::app()->name . ' - View Server Details';
		
		$modelName = 'HostingServer';
		$model = NActiveRecord::model($modelName)->findByPk($id);
		
		$this->checkModelExists($model, "<strong>No server exists for ID: ".$id."</strong>");
		
		$viewData = array(
			'model'=>$model,
		);
		
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$modelName = 'HostingServer';
		$model=new $modelName;

	// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST[$modelName]))
		{
			$model->attributes=$_POST[$modelName];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$viewData = array(
			'model'=>$model,
			'action'=>'create',
		);
		
		$this->render('edit',$viewData);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEdit($id)
	{
		$modelName = 'HostingServer';
		$model = NActiveRecord::model($modelName)->findByPk($id);
		$this->pageTitle = Yii::app()->name . ' - Edit Server Details - '.$model->name;
		
		$this->checkModelExists($model, "<strong>No server exists for ID: ".$id."</strong>");

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST[$modelName]))
		{
			$model->attributes=$_POST[$modelName];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$viewData = array(
			'model'=>$model,
			'action'=>'edit',
		);
		
		$this->render('edit',$viewData);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new HostingHosting('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['HostingHosting']))
			$model->attributes=$_GET['HostingHosting'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=HostingHosting::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	public function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='hosting-server-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
