<?php

class ErrorController extends NController 
{
	public $layout = '//layouts/login';
	/**
	 * This is the default error action when the controller doesn't know where to go
	 */
	public function actionIndex(){
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('index', $error);
		}
	}
}
