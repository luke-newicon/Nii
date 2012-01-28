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

	public function actionStep1() {

		$dbForm = new InstallDbForm();
		$userForm = new InstallUserForm();
		$this->performAjaxValidation(array($dbForm, $userForm), 'installForm');

		
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
		
		// save user details
		if (Yii::app()->request->getPost('InstallUserForm')) {
			$userForm->attributes = $_POST['InstallUserForm'];
			if ($userForm->validate())
				$userForm->createAdminUser();
		}
		
		// if database and user installed and config file saved then everything worked!
		if ($dbForm->isDbInstalled() && $dbForm->configSaved() && $userForm->isUserInstalled()) {
			$this->redirect(array('install/step2'));
		}
		// database and user successfully installed but config file not saved
		else if($dbForm->isDbInstalled() && $userForm->isUserInstalled() && !$dbForm->configSaved()){
			// we can not create the configuration file so lets show the 
			// user a nice message with instruction to create her own.
			$this->render('create-config-file', array('config' => $dbForm->generateConfigPhp(), 'configFolder' => $dbForm->getConfigFile()));
		} else {
			$this->render('step1', array('dbForm' => $dbForm,'userForm' => $userForm));
		}
	}

	public function actionStep2() {

		try {
			Yii::app()->db->getConnectionStatus();
		} catch (Exception $e) {
			if (YII_DEBUG)
				Yii::app()->user->setFlash('error-msg-debug', $e->getMessage());
			Yii::app()->user->setFlash('error', "Couldn't connect to database. Please check the details and try again!");

			//$this->redirect(array('install/step1'));
		}

		$this->render('success');
	}

	/**
	 * Enables the user to download the config file if the config folder is not writable 
	 * @param string $content the base64 encoed string of the config files content
	 */
	public function actionConfigFile($content) {

		Yii::app()->request->sendFile('local.php', base64_decode($content));
	}

}