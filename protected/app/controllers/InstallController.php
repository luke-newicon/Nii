<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InstallController
 *
 * @author robinwilliams
 */
class InstallController extends Controller {

	public $layout = '//layouts/install';

	public function actionIndex() {
		
		$this->redirect(array('install/step1'));
	}

	/**
	 * Action to install the database
	 */
	public function actionStep1() {

		$dbForm = new InstallDbForm();
		
		$this->performAjaxValidation($dbForm, 'installForm');

		// save db and install
		if (Yii::app()->request->getPost('InstallDbForm')) {
			$dbForm->attributes = $_POST['InstallDbForm'];
			if ($dbForm->validate()) {
				// install database tables and nii modules
				$dbForm->installDatabase();
				// save the config details to config file
				$dbForm->saveConfig();
			}
		}
		
		// render the install database form
		if(!$dbForm->isDbInstalled())
			$this->render('step1', array('dbForm' => $dbForm));

		// database installed but the configuration could not be saved! show a DIY message
		if($dbForm->isDbInstalled() && !$dbForm->configSaved())
			$this->render('create-config-file', array('config' => $dbForm->generateConfigPhp(), 'configFolder' => $dbForm->getConfigFile()));
		
		// database installed and config saved on to step 2!
		if($dbForm->isDbInstalled() && $dbForm->configSaved())
			$this->redirect(array('install/step2'));
		
	}

	/**
	 * Action to install the first admin user.
	 */
	public function actionStep2() {
		
		$userForm = new InstallUserForm();
		
		$this->performAjaxValidation($userForm, 'installForm');
		
		// the database must be installed to do this step
		if(!$userForm->isDbInstalled($e)){
			if (YII_DEBUG){
				if($e instanceof Exception)
					Yii::app()->user->setFlash('debug', $e->getMessage());
				else
					Yii::app()->user->setFlash('debug', 'Database details have not been saved');
			}
			Yii::app()->user->setFlash('error', "Couldn't connect to database. Please check the details and try again!");
			$this->redirect(array('install/step1'));
		}
		
		// If a user has already been installed then you are not allowed access, unless you're a superadmin perhaps
		if($userForm->isUserInstalled()){
			// redirect you don't need to creat a user, and you are no longer alloud to!
			$this->redirect(NHtml::url());
		}
		
		
		// save user details
		if (Yii::app()->request->getPost('InstallUserForm')) {
			$userForm->attributes = $_POST['InstallUserForm'];
			if ($userForm->validate()){
				$userForm->createAdminUser();
				$this->render('success');
				Yii::app()->end();
			}
		}
		

		$this->render('step2', array('userForm'=>$userForm));
	}

	/**
	 * Enables the user to download the config file if the config folder is not writable 
	 * @param string $content the base64 encoed string of the config files content
	 */
	public function actionConfigFile($content) {

		Yii::app()->request->sendFile('local.php', base64_decode($content));
	}

}