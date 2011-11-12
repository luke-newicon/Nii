<?php

class SettingsController extends AController {

	public function actionIndex() {
//		$model = new TaskSetting;
//
//		$this->performAjaxValidation($model, 'task-setting-form');
//
//		if (isset($_POST['TaskSetting'])) {
//			$model->attributes = $_POST['TaskSetting'];
//			if ($model->save()) {
//				Yii::app()->user->setFlash('success', 'Task Settings successfully saved.');
//			} else
//				Yii::app()->user->setFlash('success', 'Task Settings failed to save.');
//			$this->redirect(array('/admin/settings/index#Tasks'));
//		}
//
//		$this->render('index', array('model' => $model));
		$this->render('index');
	}

}