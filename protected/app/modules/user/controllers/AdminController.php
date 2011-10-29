<?php

class AdminController extends AController {

	private $_model;

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		return array(
			array('allow',
				'actions' => array('index', 'users', 'roles', 'addUser', 'addRole', 'editUser', 'account', 'changePassword', 'delete', 'impersonate'),
				'expression' => '$user->isSuper()'
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex() {
		$this->render('index');
	}

	/**
	 * Manages all models.
	 */
	public function actionUsers() {
		$user = UserModule::get()->userClass;
		$model = new $user('search');

		$model->unsetAttributes();
		if (isset($_GET[$user])) {
			$model->attributes = $_GET[$user];
			$model->name = $_GET[$user]['name'];
		}

		$dataProvider = $model->search();

		$this->render('users', array(
			'dataProvider' => $dataProvider,
			'model' => $model
		));
	}

	public function actionRoles() {		
		
		$columns[] = array(
				'name' => 'id',
				'header' => 'Action',
				'type' => 'raw',
				'value' => '$data[\'label\'].\' <span class="label pull-right">\'.$data[\'id\'].\'</span>\'',
			);
		
		foreach(Yii::app()->authManager->roles as $role){
			$columns[] = array(
				'name' => $role->name,
				'header' => $role->description,
				'type' => 'raw',
				'value' => 'CHtml::checkBox(\'Role[\'.$data[\'id\'].\']['.$role->name.']\',$data[\''.$role->name.'\'])',
			);
			$default[$role->name] = false;
		}
		
		$default['admin'] = true;
		
		$dataProvider = new CArrayDataProvider($this->getPermissions($default));
		
		$this->render('roles', array(
			'dataProvider' => $dataProvider,
			'columns' => $columns,
		));
	}
	
	public function getPermissions($default=array()) {
		foreach (Yii::app()->niiModules as $name => $module) {
			if (method_exists($module, 'permissions')) {
				foreach ($module->permissions() as $action => $permission) {
					$data = array('id' => $action, 'label' => $permission['label']);
					$data += $default;
					if($permission['roles']){
						foreach($permission['roles'] as $role){
							$data[$role] = true;
						}
					}
					
					$permissions[] = $data;
					
					if(isset($permission['items'])){
						$parent = $permission;
						foreach ($parent['items'] as $action => $permission) {
							$data = array('id' => $action, 'label' => $parent['label'] . ' - ' . $permission['label']);
							$data += $default;
							if($permission['roles']){
								foreach($permission['roles'] as $role){
									$data[$role] = true;
								}
							}
							$permissions[] = $data;
						}
					}
				}
			}
		}
		return $permissions;
	}
	
	public function actionAddRole(){
		$model = new AuthItem;

		$this->performAjaxValidation($model, 'add-role-form');

		if (isset($_POST['AuthItem'])) {
			$model->attributes = $_POST['AuthItem'];
			if ($model->validate()) {
				Yii::app()->authManager->createRole($model->name,$model->description);
				echo CJSON::encode(array('success' => 'Role successfully saved'));
			} else {
				echo CJSON::encode(array('error' => 'Role failed to save'));
			}
			Yii::app()->end();
		}

		$this->render('add-role', array(
			'model' => $model,
		));
	}

	public function actionAssignRoles($userId) {
		if (isset($_POST['roles'])) {
			// loop through all roles
			$auth = Yii::app()->getAuthManager();
			foreach ($auth->getAuthItems(CAuthItem::TYPE_ROLE) as $role) {
				$auth->revoke($role->name, $userId);
				$postRoles = $_POST['roles'];
				if (array_key_exists($role->name, $postRoles)) {
					// add this role to the user
					$auth->assign($role->name, $userId);
				}
			}
		}
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAddUser() {
		$model = new UserAddForm;

		$this->performAjaxValidation($model, 'add-user-form');

		if (isset($_POST['UserAddForm'])) {
			$model->attributes = $_POST['UserAddForm'];
			if ($model->validate()) {
				$model->save();
				echo CJSON::encode(array('success' => 'User successfully saved'));
			} else {
				echo CJSON::encode(array('error' => 'User failed to save'));
			}
			Yii::app()->end();
		}

		$this->render('add-user', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEditUser($id) {
		$model = UserAddForm::model()->findByPk($id);
		
		$this->performAjaxValidation($model, 'edit-user-form');

		if (isset($_POST['UserAddForm'])) {
			$model->attributes = $_POST['UserAddForm'];
			if ($model->validate()) {
				$model->password = $model->cryptPassword($model->password);
				$model->verifyPassword = $model->password;
				$model->setUserRole($model->roleName);
				if($model->save())
					echo CJSON::encode(array('success' => 'User successfully saved'));
				else
					echo CJSON::encode(array('error' => 'User failed to save'));
			} else {
				echo CJSON::encode(array('error' => 'User failed to validate'));
			}
			Yii::app()->end();
		}
		
		// Password should not be sent to the user
		$model->password = '';

		$this->render('edit-user', array(
			'model' => $model,
		));
	}

	/**
	 * User profile screen, allows the user to update their own profile
	 * information
	 */
	public function actionAccount() {
		$model = UserAccountForm::model()->findByPk(Yii::app()->user->record->id);

		$this->performAjaxValidation($model, 'user-account-form');

		if (isset($_POST['UserAccountForm'])) {
			$model->attributes = $_POST['UserAccountForm'];
			if ($model->validate()) {
				$model->password = $model->cryptPassword($model->password);
				$model->verifyPassword = $model->cryptPassword($model->password);
				if($model->save())
					echo CJSON::encode(array('success' => 'User successfully saved'));
				else
					echo CJSON::encode(array('error' => 'User failed to save'));
			} else {
				echo CJSON::encode(array('error' => 'User failed to validate'));
			}
			Yii::app()->end();
		}

		// Password should not be sent to the user
		$model->password = '';

		$this->render('account', array(
			'model' => $model,
		));

//		$user = Yii::app()->user->record;
//		$userPassword = new UserChangePassword;
//		if($user === null)
//			throw new CHttpException(404, 'User does not exist');
//		
//		// if the change password form is empty dont bother validating it
//		if(isset($_POST['UserChangePassword']['password']) && $_POST['UserChangePassword']['password'] != '')
//			$this->performAjaxValidation(array($user,$userPassword) , 'user-form');
//		else
//			$this->performAjaxValidation($user , 'user-form');
//		
//		// form submited to update user details
//		if (Yii::app()->request->getIsPostRequest() && isset($_POST['User'])) {
//			$user->attributes = $_POST['User'];
//			// handle password change
//			$userPassword->attributes = $_POST['UserChangePassword'];
//			if ($userPassword->validate()) {
//				$user->password = UserModule::passwordCrypt($userPassword->password);
//			}
//			$user->save();
//		}
//		
//		echo $this->renderPartial('personal-info', array('user'=>$user, 'userPassword'=>$userPassword), true, true);
	}

	public function actionChangePassword($id) {
		$model = $this->loadModel();
		$cp = new UserChangePassword;
		if (isset($_POST['UserChangePassword'])) {
			$cp->attributes = $_POST['UserChangePassword'];
			if ($cp->validate()) {
				$model->password = $model->cryptPassword($cp->password);
				$model->activekey = $model->cryptPassword(microtime() . $cp->password);
				$model->save();
				Yii::app()->user->setFlash('success', UserModule::t("A new password has been saved."));
			}
		}
		$this->render('changepassword', array('form' => $cp, 'model' => $model));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete() {
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_POST['ajax']))
				$this->redirect(array('/user/admin'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @return User
	 */
	public function loadModel() {
		if ($this->_model === null) {
			if (isset($_GET['id']))
				$this->_model = UserModule::userModel()->notsafe()->findbyPk($_GET['id']);
			if ($this->_model === null)
				throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * action allowing an admistrator with superuser permission to impersonate another user
	 * @param int $id the user id to impersonate
	 */
	public function actionImpersonate($id) {
		// lets double check the current user is a superuser
		if (Yii::app()->user->record->superuser) {
			$ui = UserIdentity::impersonate($id);
			if ($ui)
				Yii::app()->user->login($ui, 0);
			Yii::app()->user->setFlash('warning', "You are impersonating user: " . Yii::app()->user->name);
			$this->redirect(Yii::app()->homeUrl);
		}
	}

}