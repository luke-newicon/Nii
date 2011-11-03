<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Class AdminController extends AController {

	public function actionIndex() {
		$model = new TaskTask('search');

		$model->unsetAttributes();
		if (isset($_GET['TaskTask'])) {
			$model->attributes = $_GET['TaskTask'];
		}

		$this->render('index', array(
			'dataProvider' => $model->search(),
			'model' => $model,
		));
	}

	public function actionAddTask() {

		$model = new TaskTask;

		$this->performAjaxValidation($model, 'add-task-form');

		if (isset($_POST['TaskTask'])) {
			$model->attributes = $_POST['TaskTask'];
			if ($model->validate()) {
				$model->save();
				echo CJSON::encode(array('success' => 'Task successfully saved'));
			} else {
				echo CJSON::encode(array('error' => 'Task failed to save'));
			}
			Yii::app()->end();
		}

		$this->render('add-task', array(
			'model' => $model,
		));
	}

	public function actionActions() {
		$this->render('actions');
	}

}
