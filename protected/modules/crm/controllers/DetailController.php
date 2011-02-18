<?php

class DetailController extends Controller
{
	public function actionIndex($id){
		$c = CrmContact::model()->findByPk($id);
		
		if(!$c)
			throw new CHttpException(404, 'This contact does not exist');


		$this->render('index',array(
			'contact'=>$c,
		));
	}
}