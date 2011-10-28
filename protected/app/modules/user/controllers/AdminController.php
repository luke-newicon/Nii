<?php

class AdminController extends AController
{
	private $_model;


	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array( 
			array('allow',
				'actions'=>array('index','roles','assignRoles','view','create','update','account','changePassword','delete','impersonate'),
				'expression'=>'$user->isSuper()'
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionTest(){
		echo 'you have access!';
	}
	
	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$user = UserModule::get()->userClass;
		$model = new $user('search');
		if(isset($_GET[$user]))
			$model->attributes = $_GET[$user];

		$dataProvider=new CActiveDataProvider($user, array(
			'pagination'=>array(
//				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model
		));
	}

	public function actionRoles($id){
		$auth = Yii::app()->getAuthManager();
		$user = UserModule::userModel()->findByPk($id);
		if ($user===null)
			throw new CHttpException(404, 'No user found');
		$roles = $auth->getAuthItems(CAuthItem::TYPE_ROLE);
		$userRoles = $auth->getAuthItems(CAuthItem::TYPE_ROLE, $id);
		$this->render('roles',array(
			'roles'=>$roles,
			'userRoles'=>$userRoles,
			'model'=>$user
		));
	}
	
	public function actionAssignRoles($userId){
		if(isset($_POST['roles'])){
			// loop through all roles
			$auth = Yii::app()->getAuthManager();
			foreach($auth->getAuthItems(CAuthItem::TYPE_ROLE) as $role){
				$auth->revoke($role->name, $userId);
				$postRoles = $_POST['roles'];
				if(array_key_exists($role->name,  $postRoles)){
					// add this role to the user
					$auth->assign($role->name, $userId);
				}
			}
		}
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
		$model = new UserAddForm;
		
		$this->performAjaxValidation($model, 'add-user-form');
		
		if(isset($_POST['UserAddForm']))
		{
			$model->attributes=$_POST['UserAddForm'];
			if($model->validate()) {
				//$model->password=crypt($model->password);
				$model->save();
				echo CJSON::encode(array('success'=>'User successfully saved'));
			} else {
				echo CJSON::encode(array('error'=>'User failed to save'));
			}
			Yii::app()->end();
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
		$user = UserModule::get()->userClass;
		if(isset($_POST[$user]))
		{
			$model->attributes=$_POST[$user];
			
			if($model->validate()) {
				$model->save();
				// if we are updating our own information from this form we need
				// to reloggin
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
	
	/**
	 * User profile screen, allows the user to update their own profile
	 * information
	 */
	public function actionAccount()
	{
		$model = UserAccountForm::model()->findByPk(Yii::app()->user->record->id);
		
		$this->performAjaxValidation($model, 'user-account-form');
		
		if(isset($_POST['UserAccountForm']))
		{
			$model->attributes=$_POST['UserAccountForm'];
			if($model->validate()) {
				$model->save();
				echo CJSON::encode(array('success'=>'User successfully saved'));
			} else {
				echo CJSON::encode(array('error'=>'User failed to save'));
			}
			Yii::app()->end();
		}

		$this->render('account',array(
			'model'=>$model,
		));
	}

	public function actionChangePassword($id){
		$model = $this->loadModel();
		$cp = new UserChangePassword;
		if(isset($_POST['UserChangePassword'])){
			$cp->attributes=$_POST['UserChangePassword'];
			if($cp->validate()) {
				$model->password = $model->cryptPassword($cp->password);
				$model->activekey = $model->cryptPassword(microtime().$cp->password);
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
				$this->_model=UserModule::userModel()->notsafe()->findbyPk($_GET['id']);
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
		// lets double check the current user is a superuser
		if(Yii::app()->user->record->superuser){
			$ui = UserIdentity::impersonate($id);
			if($ui)
				Yii::app()->user->login($ui, 0);
			Yii::app()->user->setFlash('warning',"You are impersonating user: " .Yii::app()->user->name);
			$this->redirect(Yii::app()->homeUrl);
		}
	}
	
}