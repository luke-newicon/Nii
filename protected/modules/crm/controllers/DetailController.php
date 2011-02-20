<?php

class DetailController extends NiiController
{
	public function actionIndex($id=null){
		if(!$c = CrmContact::model()->findByPk($id))
			throw new CHttpException(404, 'This contact does not exist');
		
		$this->render('index',array(
			'contact'=>$c,
		));
	}
}