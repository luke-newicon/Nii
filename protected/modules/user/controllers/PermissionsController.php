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
class PermissionsController extends AdminController {

	public $defaultAction='roles';

	/**
	 * Setup the authorisation heirarchy
	 * Tasks can have child operations.
	 * An operation will not be accessible if it does not have a parent task
	 * Create tasks as top level heirarchy nodes.
	 *
	 * If you need a deeper heirarchy (deeper than two levels)
	 * this can be achieved by added child operations. e.g.
	 * task / operation / operation
	 * In this implementation the GUI will not cope with tasks as children of tasks.
	 * This does not impair functionality as the same can be achieved by using operations.
	 *
	 */
	public function actionSetupPermissions(){
		Yii::app()->getAuthManager()->clearAll();

		$auth = Yii::app()->getAuthManager();
		$auth->createRole('authenticated', 'Authenticated user', 'return !Yii::app()->user->isGuest;');
		$auth->createRole('guest', 'Guest user', 'return Yii::app()->user->isGuest;');
		$auth->createOperation('createSomething');
		$role = $auth->createRole('minion');
		$role->addChild('createSomething');
		$auth->assign('minion', Yii::app()->user->id);
		$auth=Yii::app()->authManager;
		
		
		$auth->createOperation('createPost','create a post');
		$auth->createOperation('readPost','read a post');
		$auth->createOperation('updatePost','update a post');
		$auth->createOperation('deletePost','delete a post');
		$bizRule='return Yii::app()->user->id==$params["post"]->authID;';
		$auth->createOperation('updateOwnPost','update a post by author himself',$bizRule);
		
		$posts = $auth->createTask('Posts','Manage Posts');
		$posts->addChild('createPost');
		$posts->addChild('readPost');
		$posts->addChild('updatePost');
		$posts->addChild('updateOwnPost');
		$posts->addChild('deletePost');
	

		$role=$auth->createRole('reader');
		$role->addChild('readPost');

		$role=$auth->createRole('author');
		$role->addChild('reader');
		$role->addChild('createPost');
		$role->addChild('updateOwnPost');

		$role=$auth->createRole('editor');
		$role->addChild('reader');
		$role->addChild('updatePost');

		$role=$auth->createRole('admin');
		$role->addChild('editor');
		$role->addChild('author');
		$role->addChild('deletePost');

		$auth->assign('reader','readerA');
		$auth->assign('author','authorB');
		$auth->assign('editor','editorC');
		$auth->assign('admin','adminD');
		
	}


	public function actionRoles(){

		$dummy = $this->Widget('application.widgets.jstree.CJsTree', array(
			'id'=>'dummy',
		), true);

		$model = new AuthItem('search');
		if(isset($_GET['AuthItem']))
			$model->attributes = $_GET['AuthItem'];

		$this->render('roles',array(
			'model'=>$model
		));
	}

	/**
	 * Saves a role.
	 * This action handles both the creation of a new role and
	 * updating an existing role.
	 * Important Note:
	 * When creating a new role the role name must be unique and the AuthItem model
	 * has a specific validation rule to check if the role name already exists. This is linked
	 * to the insert model scenario as during update the role name will exist and we still want
	 * the model to validate
	 */
	public function actionSaveRole(){
		// roleData is passed as a query string so we need to make this sensible
		// This also makes the ajax validate method work
		if(isset($_POST['roleData'])){
			parse_str($_POST['roleData'], $roleData);
			$_POST['AuthItem'] = $roleData['AuthItem'];
		}

		$m = new AuthItem($roleData['roleScenario']);
		$m->attributes = $_POST['AuthItem'];

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'authitem') {
			echo CActiveForm::validate($m);
			Yii::app()->end();
		}

		// will only validate successfully on insert if role does not already exist.
		// will validate successfully on update if role exists
		if(($valid = $m->validate())) {
			// if role does not exist create a new one.
			$role = Yii::app()->getAuthManager()->getAuthItem($roleData['roleOldName']);
			if($role === null){
				$role = Yii::app()->getAuthManager()->createAuthItem($m->name, 2, $m->description);
			}else{
				$role->name = $m->name;
				$role->description = $m->description;
				Yii::app()->getAuthManager()->saveAuthItem($role, $roleData['roleOldName']);
				$role = Yii::app()->getAuthManager()->getAuthItem($m->name);
			}
			// add roles
			$this->addRoles($role, Yii::app()->request->getPost('perms', array()));
			echo json_encode($valid);
			Yii::app()->end();
		}
	}

	/**
	 * used to get the role form
	 * mainly called by ajax to display form in popup window
	 * If passed a post variable of role with the role name it will load an update form
	 * if no role variable passed it will load a new create form
	 * Note: the models scenario is used to instruct the form whether it is an update or create form
	 * The models scenario is then stored in a hidden form field caled roleScenario this allows the
	 * saveRole action to know whether to insert or update.
	 */
	public function actionGetRoleForm(){
		$m = new AuthItem;
		$role = null;
		if (isset($_POST['role'])){
			$role = Yii::app()->getAuthManager()->getAuthItem($_POST['role']);
			$m = new AuthItem('update');
			$m->name = $role->name;
			$m->description = $role->description;
		}
		echo $this->render('roleform',array(
			'model'=>$m,
			'permissions'=>AuthItem::model()->getPermissionsTreeData($role),
			'role'=>$role
		), true);
		Yii::app()->end();
	}

	/**
	 * Adds permissions to a role
	 * Does not respect the heirarchy and adds all permissions as direct children of the role.
	 * Meaning all permissions can be easily removed from a role by using $role->getChildren
	 * which will return all of the roles permissions
	 *
	 * @param CAuthItem $role
	 * @param array $perms array of authitem names
	 */
	public function addRoles(CAuthItem $role, $perms){
		foreach($role->getChildren() as $r){
			$role->removeChild($r->name);
		}
		if(!empty($perms)){
			foreach($perms as $p){
				//echo 'add child: ' . $p . '<br/>';
				$role->addChild($p);
			}
		}
	}

	/**
	 * action not yet used!
	 * intended to show a page listing the users belonging to a particular role.
	 * @param string $role
	 */
	public function actionUsersInRole($role){
		$auth = Yii::app()->getAuthManager();
		$role = $auth->getAuthItem($role);

		if($role === null)
			throw new CHttpException (404, 'Can not find a role with this name');

	}

}