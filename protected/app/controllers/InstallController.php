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
		
		if (Yii::app()->request->getPost('InstallForm')){
			
			if ($model->installDb == true) {

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

					$data = '<?php '."\n".'return '.var_export($config,true).';';

					if ($model->installDb == true) {
						$filename = Yii::getPathOfAlias('app.config.local').'.php';
                        if (is_writable(Yii::getPathOfAlias('app.config'))) {
                            file_put_contents($filename, $data);
                            chmod($filename,0777);
                        } else {
                            // we can not create the configuration file so lets show the 
                            // user a nice message with instruction to create her own.
                            $this->render('create-config-file',array('config'=>$data, 'configFolder'=>dirname($filename)));
                            Yii::app()->end();
                        }
					}

					Yii::app()->setComponents($config['components']);

				}
			} else if ($model->installDb == false) {
				$model->attributes = $_POST['InstallForm'];
			}
			
		}
		
		if (Yii::app()->request->getPost('InstallForm')) {
            if ($model->validate()) {
                try { 

                    Yii::app()->db->getConnectionStatus();

                    NActiveRecord::install('Setting');
                    NActiveRecord::install('Log');

                    Yii::app()->install();

                    // if the user already exists we will still make it work
                    $user = User::model()->findByAttributes(array('username'=>$model->username));
                    if ($user === null)
                        $user = new User;
                    // if the username
                    if ($user->getScenario() != 'insert') {
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
                    if(YII_DEBUG)
                        throw new CException($e);
                    Yii::app()->user->setFlash('error', "Couldn't connect to database. Please check the details and try again!");
                }
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
			if(YII_DEBUG){
				throw new CException($e);
			}
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
    
    /**
     * Enables the user to download the config file if the config folder is not writable 
     * @param string $content the base64 encoed string of the config files content
     */
    public function actionConfigFile($content){
        
        Yii::app()->request->sendFile('local.php',base64_decode($content));
        
    }
	
}