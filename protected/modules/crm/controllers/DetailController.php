<?php

class DetailController extends NAController
{
	public function actionIndex($id=null){
		if(!$c = CrmContact::model()->findByPk($id))
			throw new CHttpException(404, 'This contact does not exist');
		
		echo $this->render('index',array(
			'contact'=>$c,
		), true);
	}
}