<?php

class SettingsController extends AController {

	public function actionIndex() {
		$settings = $this->settings;
		$this->render('index', array('settings' => $settings));
	}

	public function actionPage($module) {
		$this->layout = '//layouts/ajax';
		$module = Yii::app()->getModule($module);
		$this->render('page', array('title' => $module->name, 'content' => $module->settingsPage()));
	}

	public function actionGeneral() {
		$this->render('general');
	}
	
	public function actionPresentation() {
		$model = new AdminPresentationSetting;
		
		$this->render('presentation',array('model'=>$model));
	}

	public function getSettings() {
		foreach (Yii::app()->niiModules as $name => $module) {
			if (method_exists($module, 'settings')) {
				foreach ($module->settings() as $page => $url) {
					$settings[$page] = array('name' => $page, 'url' => $url, 'ajax' => true);
				}
			}
		}
		return $settings;
	}

}