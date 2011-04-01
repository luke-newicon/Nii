<?php

/**
 * PermissionsController class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of PermissionsController
 *
 * @author steve
 */
class PermissionsController extends NAController {
	
	public function actionIndex() {
		$this->render('index');
	}

	public function setupPermissions(){
		Yii::app()->getAuthManager()->clearAll();

		$auth = Yii::app()->getAuthManager();
		$auth->createRole('authenticated', 'Authenticated user', 'return !Yii::app()->user->isGuest;');
		$auth->createRole('guest', 'Guest user', 'return Yii::app()->user->isGuest;');
		$auth->createOperation('createSomething');
		$role = $auth->createRole('minion');
		$role->addChild('createSomething');
		$auth->assign('minion', Yii::app()->user->id);
	}
	
	public function actionRoles(){
		$model = new AuthItem('search');
		if(isset($_GET['AuthItem']))
			$model->attributes = $_GET['AuthItem'];

		$this->render('roles',array(
			'model'=>$model
		));
	}

	

	public function actionCreateRoleForm(){
		$m = new AuthItem;

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'authitem') {
			echo CActiveForm::validate($m);
			Yii::app()->end();
		}

		if(isset($_POST['AuthItem'])){
			$m->attributes = $_POST['AuthItem'];
			if(($valid = $m->validate())) {
				Yii::app()->getAuthManager()->createAuthItem($m->name, 2, $m->description);
			}
			echo json_encode($valid);
			Yii::app()->end();
		}
		
		echo $this->render('roleform',array(
			'model'=>$m
		), true);
		Yii::app()->end();
	}

	public function actionRole($id){
		$auth = Yii::app()->getAuthManager();
//		$auth->clearAll();
//
//		$task=$auth->createTask('Posts','posts');
//		$auth->createOperation('createPost','create a post');
//		$auth->createOperation('readPost','read a post');
//		$auth->createOperation('updatePost','update a post');
//		$auth->createOperation('deletePost','delete a post');
//
//
//		$task->addChild('createPost');
//		$task->addChild('readPost');
//		$task->addChild('updatePost');
//		$task->addChild('deletePost');
//
//		$auth->createOperation('some operation','create a post');
//
//		$auth->createTask('some task','create a post');
//		$auth->createRole('some role','create a post');
//		$auth->createRole($id);

		$role = Yii::app()->getAuthManager()->getAuthItem($id);
//		$role->addChild('updatePost');
//		$role->addChild('readPost');
//		$role->addChild('createPost');
//		$role->addChild('updateOwnPost');
		//dp(AuthItem::model()->getPermissionsTreeData());
		$permissions = AuthItem::model()->getPermissionsTreeData($role);

		if($role === null)
			throw new CHttpException (404, 'Can not find a role with this name');

		$this->render('role', array(
			'permissions'=>$permissions,
			'role'=>$role
		));
	}


	public function actionUsersInRole($role){
		$auth = Yii::app()->getAuthManager();
		$role = $auth->getAuthItem($role);

		if($role === null)
			throw new CHttpException (404, 'Can not find a role with this name');

	}

}