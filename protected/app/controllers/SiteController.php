<?php

class SiteController extends Controller {

	/**
	 * Declares class-based actions.
	 */
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page' => array(
				'class' => 'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {
		$this->menu = array(
			array('label' => 'Newicon', 'url' => array('/site/index'), 'template'=>'<a style="padding:3px 8px;margin-left:0px;" href="'.NHtml::url('/site/index').'"><img style="padding-top:3px;" alt="Newicon" src="'.Yii::app()->request->baseUrl.'/images/newicon.png" /></a>'),
			array('label' => 'Register', 'url' => array('/user/account/registration')),
		);
		$this->render('index');
	}

	public function actionWebsites() {
		$this->render('websites');
	}

	public function actionBlog() {
		$this->render('blog');
	}

	public function actionResources() {
		$this->render('resources');
	}

	public function actionSupport() {
		$this->render('support');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

}