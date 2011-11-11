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
			if ($model->save()) {
				Yii::app()->user->setFlash('success','General Settings successfully saved.');
			} else
				Yii::app()->user->setFlash('success','General Settings failed to save.');
			$this->redirect(array('index'));
		}

		$this->render('general', array('model' => $model));
	}

	public function actionPresentation() {
		$model = new AdminPresentationSetting;
		
		$this->performAjaxValidation($model, 'settings-presentation-form');

		if (isset($_POST['AdminPresentationSetting'])) {
			$model->attributes = $_POST['AdminPresentationSetting'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success','Presentation Settings successfully saved.');
			} else
				Yii::app()->user->setFlash('success','Presentation Settings failed to save.');
			$this->redirect(array('index'));
		}
		
		$this->render('presentation', array('model' => $model));
	}

	public function getSettings() {
		foreach (Yii::app()->modules as $name => $config) {
			$module = Yii::app()->getModule($name);
			if (method_exists($module, 'settings')) {
				foreach ($module->settings() as $id => $setting) {
					if (is_string($setting)) {
						$label = NHtml::generateAttributeLabel($id);
						$url = CHtml::normalizeUrl(array($setting));
					} else {
						$label = isset($setting['label']) ? $setting['label'] : NHtml::generateAttributeLabel($id);
						$url = isset($setting['url']) ? CHtml::normalizeUrl($setting['url']) : '#';
					}
					$settings['items'][] = array('label' => $label, 'url' => '#' . $id);
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