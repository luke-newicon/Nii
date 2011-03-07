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
	
	public function actionRoles(){
		
		$roles = Yii::app()->authManager->getAuthItems(2);
		foreach($roles as $i =>$v){
			echo $i;
		}
		if(Yii::app()->user->checkAccess('createSomething')){
			echo 'i can create something!';
		}else{
			echo 'i cannot';
		}
		$this->render('roles');
	}

}