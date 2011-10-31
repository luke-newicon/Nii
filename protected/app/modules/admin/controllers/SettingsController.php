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
		$model = new AdminGeneralSetting;

		$this->performAjaxValidation($model, 'settings-general-form');

		if (isset($_POST['AdminGeneralSetting'])) {
			$model->attributes = $_POST['AdminGeneralSetting'];
			if ($model->validate())
				echo CJSON::encode(array('success' => 'Settings successfully saved'));
			else
				echo CJSON::encode(array('error' => 'Settings failed to validate'));
			Yii::app()->end();
		}

		$this->render('general',array('model'=>$model));
	}
	
	public function actionPresentation() {
		$model = new AdminPresentationSetting;
		$this->render('presentation',array('model'=>$model));
	}

	public function getSettings() {
		foreach (Yii::app()->niiModules as $name => $module) {
			if (method_exists($module, 'settings')) {
				foreach ($module->settings() as $id => $setting) {
					if(is_string($setting)){
						$label = NHtml::generateAttributeLabel($id);
						$url = CHtml::normalizeUrl(array($setting));
					} else {
						$label = isset($setting['label']) ? $setting['label'] : NHtml::generateAttributeLabel($id);
						$url = isset($setting['url']) ? CHtml::normalizeUrl($setting['url']) : '#';
					}
					$settings['items'][] = array('label' => $label, 'url' => '#'.$id);
					$page = array('label' => $label, 'htmlOptions' => array('id' => $id, 'data-ajax-url' => $url));
					$settings['pages'][] = $page;
				}
			}
		}
		$settings['items'][0]['itemOptions']['class'] = 'active';
		$settings['pages'][0]['htmlOptions']['class'] = 'active';
		return $settings;
	}

}