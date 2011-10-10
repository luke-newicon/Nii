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
		
		$comps = Yii::app()->getComponents(false);
		
		if (isset($comps->db->connectionString))
			$model->installDb = false;
		else
			$model->installDb = true;
				
		if ($_POST['InstallForm'] && $model->installDb == true) {

				$model->attributes = $_POST['InstallForm'];
				
				if ($model->validate()) {
					
					$config['name'] = $model->sitename;
					$config['timezone'] = $model->timezone;
					$config['hostname'] = $model->hostname;

					$config['components']['db']['connectionString'] = 'mysql:host='.$model->db_host.';dbname='.$model->db_name;
					$config['components']['db']['username'] = $model->db_username;
					$config['components']['db']['password'] = $model->db_password;
					$config['components']['db']['tablePrefix'] = $model->db_tablePrefix;
					
					$config['params']['adminEmail'] = $model->email;

					$data = '<?php return '.var_export($config,true).';';
					
					if ($model->installDb == true) {
						$filename = Yii::getPathOfAlias('app.config.local').'.php';
						file_put_contents($filename, $data);
						chmod($filename,0777);
					}

					Yii::app()->setComponents($config['components']);
				
				}
		} else if ($_POST['InstallForm'] && $model->installDb == false) {
			$model->attributes = $_POST['InstallForm'];
		}
		
		if ($_POST['InstallForm']) {
			
			try { 
				Yii::app()->db->getConnectionStatus();

				$models = array(
					'Log','Setting','User',
					'NNote','NFile','AuthItem','AuthAssignment','AuthItemChild',
				);

				foreach ($models as $m)
					NActiveRecord::install($m);

				Yii::app()->cache->flush();

				$user = User::model()->findByAttributes(array('username'=>$model->username));
				if (!$user->username)
					$user = new User;
				
				if ($user->username) {
					$user->password = $user->cryptPassword($model->password);
					$user->activekey = $user->cryptPassword(microtime().$model->password);
				} else {
					$user->password = $model->password;
				}
				
				$user->username = $model->username;
				$user->email = $model->email;
				$user->superuser = 1;
				$user->status = 1;

				if ($user->validate()) {
					$user->save();
					$this->redirect (array('install/step2'));
				}

			} catch (Exception $e) {
				Yii::app()->user->setFlash('error', "Couldn't connect to database. Please check the details and try again!");
			}
			
		}
		
		$localConfig = Yii::getPathOfAlias('app.config.local').'.php';
		if (file_exists($localConfig)) {
			$local = require $localConfig;
			$model->getLocalConfig($local);
		}
				
		$this->render('step1',
			array(
				'model'=>$model,
			)
		);
	}
	
	public function actionStep2() {
		try { 
			Yii::app()->db->getConnectionStatus();
		} catch (Exception $e) {
			Yii::app()->user->setFlash('error-msg',"Couldn't connect to database. Please check the details and try again!");
			$this->redirect (array('install/step1'));
		}
	
		$model = new InstallForm;

		$this->render('success',
			array(
				'model'=>$model,
			)
		);
		
	}
	
}