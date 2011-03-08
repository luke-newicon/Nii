<?php

class IndexController extends NAController
{
	
	
	public function accessRules() {
		return CMap::mergeArray(array(
			array('allow',
				'actions'=>array('login','index','logout'),
				'users'=>array('*')
			)),
			parent::accessRules()
		);
		
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
	
		$model= new User('search');
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];
		$this->render('/user/index',array(
			'model'=>$model
		));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastVisit();
					if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}

	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->controller->module->returnLogoutUrl);
	}

	private function lastVisit() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}



	



}