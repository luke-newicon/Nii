<?php

Class FeedbackController extends NController
{
	public function actionSend(){
		$fb = $_POST['feedback'];
		$user = Yii::app()->user->getName();
		$userId = Yii::app()->user->getId();
		mail('theteam@newicon.net', 'feedback', $fb."\n"." user: $user \n user-id: $userId");
	}
}