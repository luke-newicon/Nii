<?php

class SettingsController extends AController {

	public function actionIndex() {
		$model = new KashflowSetting;

		$this->performAjaxValidation($model, 'kashflow-setting-form');

		if (isset($_POST['KashflowSetting'])) {
			$model->attributes = $_POST['KashflowSetting'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Kashflow Settings successfully saved.');
			} else
				Yii::app()->user->setFlash('success', 'Kashflow Settings failed to save.');
			$this->redirect(array('/admin/settings/index#Kashflow'));
		}

		$this->render('index', array('model' => $model));
	}

}