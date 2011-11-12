<?php

class SettingsController extends AController {

	public function actionIndex() {
		$model = new ContactSetting;

		$this->performAjaxValidation($model, 'contact-setting-form');

		if (isset($_POST['ContactSetting'])) {
			$model->attributes = $_POST['ContactSetting'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Contact Settings successfully saved.');
			} else
				Yii::app()->user->setFlash('success', 'Contact Settings failed to save.');
			$this->redirect(array('/admin/settings/index#Contacts'));
		}

		$this->render('index', array('model' => $model));
	}

}