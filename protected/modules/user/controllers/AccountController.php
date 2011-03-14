<?php

class AccountController extends NAController {

	/**
	 * @var string the default layout for the controller view.
	 */
	public $layout = '//layouts/login';

	public function accessRules() {
		return CMap::mergeArray(array(
			array('allow',
				'actions' => array('login', 'logout'),
				'users' => array('*')
				)),
				parent::accessRules()
		);
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		if (Yii::app()->user->isGuest) {
			$model = new UserLogin;
			// collect user input data
			if (isset($_POST['UserLogin'])) {
				$model->attributes = $_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if ($model->validate()) {
					$this->lastVisit();
					if (strpos(Yii::app()->user->returnUrl, '/index.php') !== false)
						$this->redirect(Yii::app()->getModule('user')->returnUrl);
					else
						$this->redirect(Yii::app()->getModule('user')->returnUrl);
				}
			}
			// display the login form
			$this->render('/user/login', array('model' => $model));
		} else
			$this->redirect(Yii::app()->getModule('user')->returnUrl);
	}

	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->getModule('user')->returnLogoutUrl);
	}

	private function lastVisit() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

}