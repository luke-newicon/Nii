<?php

class HolidayController extends AController {

	public function accessRules() {
		return array(
			array('allow',
				'users' => array('@'),
			),
			array('deny', // deny all users
				'users' => array('?'),
			),
		);
	}
	
	/**
	 * Displays all the holidays for the currently logged in user
	 */
	public function actionIndex() {
		$model=new TimesheetHoliday('search');
		$model->unsetAttributes();
		
		if(isset($_GET['TimesheetHoliday']))
			$model->attributes=$_GET['TimesheetHoliday'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Add a new holiday booking to the system
	 */
	public function actionCreate()
	{		
		$model = new TimesheetHoliday;

		$this->performAjaxValidation($model, 'TimesheetHoliday');

		if (isset($_POST['TimesheetHoliday'])) {
			$model->attributes = $_POST['TimesheetHoliday'];
			
			$model->user_id = Yii::app()->user->id;
			if ($model->validate()) {
				if ($model->save()) {
					echo CJSON::encode(array('success' => 'Holiday successfully saved'));
					Yii::app()->end();
				}
			}
			echo CJSON::encode(array('error' => 'Holiday failed to save'));
			Yii::app()->end();
		}

		$this->render('createUpdate', array(
			'model' => $model,
			'userId'=>Yii::app()->user->id,
			'title'=>'Book new holiday'
		));
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			TimesheetHoliday::model()->findByPk($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

}
