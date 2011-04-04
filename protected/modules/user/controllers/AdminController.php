<?php

class AdminController extends AController
{
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'users'=>UserModule::getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model = new User('search');
		if(isset($_GET['User']))
			$model->attributes = $_GET['User'];

		$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model
		));
	}


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
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
		$model = new User;
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->validate()) {
				//$model->password=crypt($model->password);
				$model->save();
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			
			if($model->validate()) {
				$model->save();
				// if we are updating our own information from this form we need to reloggin
				if(Yii::app()->user->id == $model->id){
					$ui = UserIdentity::impersonate($model->id);
					Yii::app()->user->login($ui,0);
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionChangePassword($id){
		$model = $this->loadModel();
		$cp = new UserChangePassword;
		if(isset($_POST['UserChangePassword'])){
			$cp->attributes=$_POST['UserChangePassword'];
			if($cp->validate()) {
				$model->password = $cp->password;
				$model->cryptPassword();
				$model->save();
				Yii::app()->user->setFlash('success',UserModule::t("A new password has been saved."));
			}
		}
		$this->render('changepassword', array('form'=>$cp,'model'=>$model));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('/user/admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @return User
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}


	/**
	 * action allowing an admistrator with superuser permission to impersonate another user
	 * @param int $id the user id to impersonate
	 */
	public function actionImpersonate($id)
	{
		$ui = UserIdentity::impersonate($id);
		if($ui)
			Yii::app()->user->login($ui, 0);
		Yii::app()->user->setFlash('warning',"The impersonate function currently has no authentication or permission checking!!");
		$this->redirect(Yii::app()->homeUrl);
	}
	
}