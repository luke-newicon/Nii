<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Base class for install forms of Install
 *
 * @author steve
 */
class InstallForm extends CFormModel
{

	
	
	public function getConfigFile(){
		return Yii::getPathOfAlias('app.config.local') . '.php';
	}
	
	/**
	 * Check if the database connection details are already installed
	 * NOTE: The database details are added to Yii component db setting before the config file is created.
	 * NOTE: The database might be installed but the config file might not exist yet
	 * @return boolean
	 */
	public function isDbInstalled(){
		// if the db component is already configured then we already have a configuration for the database.
		// this enables the view to display the install user form, and hides the database details.
		$comps = Yii::app()->getComponents(false);
		if(array_key_exists('db', $comps)){
			$db = $comps['db'];
			if($db instanceof CDbConnection){
				if($db->connectionString != '' && $db->username != ''){
					try {
						Yii::app()->db->getConnectionStatus();
						return true;
					} catch (Exception $e){

					}
				}
			}
		}
		return false;
	}
	
	/**
	 * Checks if the local config file with database details has been saved
	 * @return boolean
	 */
	public function configSaved(){
		return file_exists($this->getConfigFile());
	}
	
}

