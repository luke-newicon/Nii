<?php

class AdminController extends AController {

	private $_model;

	/**
	 * Manages all models.
	 */
	public function actionIndex() {
		$this->render('index');
	}

	public function actionSettings() {
		$this->render('settings');
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

	public function actionPermissions() {
		if (Yii::app()->authManager->getAuthItem('task-admin-permissions')) {
			foreach (Yii::app()->authManager->getItemChildren('task-admin-permissions') as $task) {
				$label = $task->description ? $task->description : NHtml::generateAttributeLabel($task->name);
				$url = CHtml::normalizeUrl(array('/user/admin/permission', 'id' => $task->name));
				$permissions['items'][] = array('label' => $label, 'url' => '#' . $task->name);
				$permissions['pages'][] = array('label' => $label, 'htmlOptions' => array('id' => $task->name, 'data-ajax-url' => $url));
			}
		}

		$permissions['items'][0]['itemOptions']['class'] = 'active';
		$permissions['pages'][0]['htmlOptions']['class'] = 'active';

		$this->render('permissions', array(
			'permissions' => $permissions,
		));
	}

	public function actionPermission($id) {
		$columns[] = array(
			'name' => 'description',
			'header' => 'Tasks',
		);

		foreach (Yii::app()->authManager->roles as $role) {
			$columns[] = array(
				'type' => 'raw',
				'header' => $role->description,
				'value' => '$data->displayRoleCheckbox(\'' . $role->name . '\')',
				'htmlOptions' => array('width' => '30px'),
			);
		}

		$model = UserTask::model()->findByPk($id);

		$this->render('permission', array(
			'id' => $id . '-permissions',
			'dataProvider' => $model->search(),
			'columns' => $columns,
		));
	}

	public function actionUpdatePermission() {
		try {
			if (isset($_POST['Permission'])) {
				foreach ($_POST['Permission'] as $taskName => $role) {
					foreach ($role as $roleName => $child) {
						if ($child && !Yii::app()->authManager->hasItemChild($roleName, $taskName)) {
							Yii::app()->authManager->addItemChild($roleName, $taskName);
							echo CJSON::encode(array('success' => 'Permission successfully added'));
						} else {
							if (Yii::app()->authManager->removeItemChild($roleName, $taskName))
								echo CJSON::encode(array('success' => 'Permission successfully removed'));
							else
								echo CJSON::encode(array('error' => 'Permission failed to be removed'));
						}
					}
				}
			}
		} catch (CException $e) {
			echo CJSON::encode(array('error' => 'Permission failed to be added'));
		}
		Yii::app()->end();
	}

	public function getPermissions($id, $moduleName) {
		$module = Yii::app()->getModule($moduleName);
		if (method_exists($module, 'permissions')) {
			$modulePermissions = $module->permissions();
			if (is_array($modulePermissions)) {
				foreach ($modulePermissions[$id]['tasks'] as $taskId => $task) {
					$data = array('id' => $taskId, 'label' => $task['description']);
					if (isset($task['roles'])) {
						foreach (Yii::app()->authManager->roles as $role) {
							if (in_array($role->name, $task['roles']))
								$data[NHtml::generateAttributeId($role->name)] = true;
							elseif (array_key_exists($role->name, $task['roles']))
								$data[NHtml::generateAttributeId($role->name)] = $task['roles'][$role->name];
							else
								$data[NHtml::generateAttributeId($role->name)] = false;
						}
					}
					$operations = '';
					if (isset($task['operations'])) {
						$operations .= '<div>';
						foreach ($task['operations'] as $operation) {
							$operations .= '<span class="label">' . $operation . '</span> ';
						}
						$operations .= '<div>';
					}
					$data['operations'] = $operations;
					$permissions[] = $data;
				}
			}
		}
		return $permissions;
	}

	public function actionAddRole() {
		$model = new UserRole;

		$this->performAjaxValidation($model, 'add-role-form');

		if (isset($_POST['UserRole'])) {
			$model->attributes = $_POST['UserRole'];
			$model->description = $model->name;
			$model->name = 'role-'.NHtml::generateAttributeId($model->description);
			if ($model->validate()) {
				Yii::app()->authManager->createRole($model->name, $model->description);
				if($model->copy){
					foreach(Yii::app()->authManager->getItemChildren($model->copy) as $child){
						if(!Yii::app()->authManager->hasItemChild($model->name,$child->name))
							Yii::app()->authManager->addItemChild($model->name,$child->name);
					}
				}
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
				if ($model->save()) {
					$model->saveRole();
					echo CJSON::encode(array('success' => 'User successfully saved'));
				} else
					echo CJSON::encode(array('error' => 'User failed to save'));
			} else {
				echo CJSON::encode(array('error' => 'User failed to validate'));
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
		$model = UserEditForm::model()->findByPk($id);

		$this->performAjaxValidation($model, 'edit-user-form');

		if (isset($_POST['UserEditForm'])) {
			$oldPassword = $model->password;
			$model->attributes = $_POST['UserEditForm'];
			if ($model->validate()) {
				if ($model->password) {
					$model->password = $model->cryptPassword($model->password);
					$model->verifyPassword = $model->password;
				} else {
					$model->password = $oldPassword;
					$model->verifyPassword = $oldPassword;
				}
				if ($model->save()) {
					$model->saveRole();
					echo CJSON::encode(array('success' => 'User successfully saved'));
				} else
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
				if ($model->save())
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