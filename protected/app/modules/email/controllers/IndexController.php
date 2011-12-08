<?php

class IndexController extends AController
{
	
	public function actionIndex()
	{
		$model = new EmailCampaign;
		$this->render('index', array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
	}
	
	public function actionCreate() {
		
		$this->pageTitle = Yii::app()->name . ' - New Email Campaign';
		$modelName = 'EmailCampaign';
		
		$model = new $modelName;
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$modelName])) {
			$model->attributes = $_POST[$modelName];
			
			if($model->save()) {
				
				NLog::insertLog('Inserted new template details (id: '.$model->id.')', $model);
				$this->redirect(array("template/send","id"=>$model->id));		
			}
		}
		
		$this->render('create', array(
			'model'=>$model,
		));
	}
	
	public function actionRecipients($q){
		$q = urldecode($_GET['q']);
		// escape % and _ characters
		$q = strtr($q, array('%'=>'\%', '_'=>'\_'));
		$data = array();
		
		// Search in database-based groups
		$groups = ContactGroup::model()->findAll(
			array(
				'condition'=>"name LIKE '".$q."%' OR label LIKE '".$q."%'",
				'limit'=>30,
			)
		);
		
		if ($groups) {
			$data[] = array('id'=>'', 'name'=>'Groups','type'=>'header');
			foreach($groups as $g)
				$data[] = array('id'=>$g->id, 'name'=>$g->label);
		}
		
		$contacts = Contact::model()->findAll(
			array(
				'condition'=>"lastname LIKE '".$q."%' OR givennames LIKE '".$q."%'",
				'limit'=>30,
			)
		);
		if ($contacts) {
			$data[] = array('id'=>'', 'name'=>'Contacts','type'=>'header');
			foreach($contacts as $c){
				$data[] = array('id'=>$c->id, 'name'=>$c->name);
			}		
		}
		echo CJSON::encode($data);
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	public function performAjaxValidation($model,$class='')
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===$class.'Form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}

