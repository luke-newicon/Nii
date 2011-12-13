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
	
	public function actionCreate($recipients=null) {
		
		$this->pageTitle = Yii::app()->name . ' - New Email Campaign';
		$modelName = 'EmailCampaign';
		
		$model = new $modelName;
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$modelName])) {
			$model->attributes = $_POST[$modelName];
			$model->created_date = date('Y-m-d H:i:s');
			
			if ($model->save())
				$this->redirect(array('preview','id'=>$model->id));
		} elseif (isset($recipients)) {
			$model->recipients = $recipients;
			$model->template_id = 0;
		}
		
		$this->render('create', array(
			'model'=>$model,
		));
	}
	
	public function actionPreview($id, $contact_id=null) {
		
		$this->pageTitle = Yii::app()->name . ' - Preview Email Campaign';
		
		$model = EmailCampaign::model()->findByPk($id);
		
		$this->render('preview', array(
			'model'=>$model,
		));
	}
	
	public function actionRecipients($q){
		$q = urldecode($_GET['q']);
		// escape % and _ characters
		$q = strtr($q, array('%'=>'\%', '_'=>'\_'));
		$data = array();
		
		// Search in database-based groups
		$groups = ContactGroup::searchGroups($q);
		
		if ($groups) {
			$data[] = array('id'=>'', 'name'=>'Groups','type'=>'header');
			foreach($groups as $g)
				$data[] = array('id'=>'g_'.$g->id, 'name'=>$g->name);
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
				$data[] = array('id'=>'c_'.$c->id, 'name'=>$c->name);
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

