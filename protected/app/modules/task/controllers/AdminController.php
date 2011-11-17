<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Class AdminController extends AController {

	public function actionIndex() {
		$this->redirect(array('tasks'));
	}

	public function actionTasks() {
		$model = new TaskTask('search');

		$model->unsetAttributes();
		if (isset($_GET['TaskTask'])) {
			$model->attributes = $_GET['TaskTask'];
		}

		$this->render('tasks', array(
			'dataProvider' => $model->search(),
			'model' => $model,
		));
	}
	
	public function actionProjects(){
		$this->render('projects');
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

		$this->render('task/add', array(
			'model' => $model,
		));
	}

	public function actionViewTask($id) {

		$model = TaskTask::model()->findByPk($id);

		$this->render('task/view', array(
			'model' => $model,
		));
	}

	public function actionEditTask($id) {

		$model = TaskTask::model()->findByPk($id);

		$this->performAjaxValidation($model, 'edit-task-form');

		if (isset($_POST['TaskTask'])) {
			$model->attributes = $_POST['TaskTask'];
			if ($model->validate()) {
				$model->save();
				if (Yii::app()->request->isAjaxRequest) {
					echo CJSON::encode(array('success' => 'Task successfully saved'));
				} else {
					Yii::app()->user->setFlash('success', 'Task successfully saved');
					$this->redirect(array('viewTask', 'id' => $model->id()));
				}
				Yii::app()->end();
			} else {
				if (Yii::app()->request->isAjaxRequest) {
					echo CJSON::encode(array('error' => 'Task failed to save'));
					Yii::app()->end();
				} else {
					Yii::app()->user->setFlash('error', 'Task failed to save');
				}
			}
		}

		$this->render('task/edit', array(
			'model' => $model,
		));
	}

	public function actionDeleteTask($id) {

		$model = TaskTask::model()->findByPk($id);

		if ($model->delete())
			Yii::app()->user->setFlash('success', 'Task successfully deleted');
		else
			Yii::app()->user->setFlash('success', 'Task failed to delete');
		$this->redirect(array('tasks'));
	}

	public function actionActions() {
		$this->render('actions');
	}

}
