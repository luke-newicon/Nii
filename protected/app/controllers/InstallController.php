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


		$model = new InstallForm;

		$this->performAjaxValidation($model, 'installForm');

		// if the db component is already configured then we already have a configuration for the database.
		// this enables the view to display the install user form, and hides the database details.
		$comps = Yii::app()->getComponents(false);
		$model->installDb = !array_key_exists('connectionString', $comps['db']);


		if (Yii::app()->request->getPost('InstallForm')) {

			$model->attributes = $_POST['InstallForm'];

			if ($model->validate()) {

				$config = $model->generateConfig();

				$data = '<?php ' . "\n" . 'return ' . var_export($config, true) . ';';

				// install database tables and nii modules
				$model->installDatabase();

				// inserts the admin user
				$model->createAdminUser();

				$filename = Yii::getPathOfAlias('app.config.local') . '.php';
				

				// if the config file has been written then install has completed!
				if (file_exists($filename)) {
					$this->redirect(array('install/step2'));
				} else {
					if (is_writable(dirname($filename))) {
						file_put_contents($filename, $data);
					} else {
						// we can not create the configuration file so lets show the 
						// user a nice message with instruction to create her own.
						$this->render('create-config-file', array('config' => $data, 'configFolder' => dirname($filename)));
						Yii::app()->end();
					}
				}
			}
		} else {
			$localConfig = Yii::getPathOfAlias('app.config.local') . '.php';
			if (file_exists($localConfig)) {
				$local = require $localConfig;
				$model->getLocalConfig($local);
			}
		}

		$this->render('step1', array(
			'model' => $model,
		));
	}

	public function actionStep2() {

		try {
			Yii::app()->db->getConnectionStatus();
		} catch (Exception $e) {
			if (YII_DEBUG)
				Yii::app()->user->setFlash('error-msg-debug', $e->getMessage());
			Yii::app()->user->setFlash('error', "Couldn't connect to database. Please check the details and try again!");

			$this->redirect(array('install/step1'));
		}

		$model = new InstallForm;

		$this->render('success', array(
			'model' => $model,
				)
		);
	}

	/**
	 * Enables the user to download the config file if the config folder is not writable 
	 * @param string $content the base64 encoed string of the config files content
	 */
	public function actionConfigFile($content) {

		Yii::app()->request->sendFile('local.php', base64_decode($content));
	}

}