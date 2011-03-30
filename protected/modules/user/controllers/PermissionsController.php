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

		$this->render('roles',array(
			'roles'=>$roles,
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
			if(($valid = $m->validate)) {
				Yii::app()->getAuthManager()->createAuthItem($m->name, 2, $m->description);
			}
			echo json_encode($valid);
			Yii::app()->end();
		}

		$this->render('roleform',array(
			'model'=>$m
		));
	}

}