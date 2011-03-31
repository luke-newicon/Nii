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
		Yii::app()->getAuthManager()->clearAll();

		$auth = Yii::app()->getAuthManager();
		$auth->createRole('authenticated', 'Authenticated user', 'return !Yii::app()->user->isGuest;');
		$auth->createRole('guest', 'Guest user', 'return Yii::app()->user->isGuest;');
		$auth->createOperation('createSomething');
		$role = $auth->createRole('minion');
		$role->addChild('createSomething');
		$auth->assign('minion', Yii::app()->user->id);
		$this->render('index');
	}
	
	public function actionRoles(){


		$roles = Yii::app()->getAuthManager()->getAuthItems(2);

		$model = new AuthItem('search');
		if(isset($_GET['AuthItem']))
			$model->attributes = $_GET['AuthItem'];

		$this->render('roles',array(
			'roles'=>$roles,
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

		$role = Yii::app()->getAuthManager()->getAuthItem($id);
		
		if($role === null)
			throw new CHttpException (404, 'Can find a role with this name');

		$this->render('role', array(
			'role'=>$role
		));
	}

}