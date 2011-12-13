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
	
	public function actionCreate($id=null, $recipients=null) {
		
		$this->pageTitle = Yii::app()->name . ' - New Email Campaign';
		$modelName = 'EmailCampaign';
		
		if ($id) {
			$model = EmailCampaign::model()->findByPk ($id);
			$model->updated_date = date('Y-m-d H:i:s');
		}
		if (!isset($model)) {
			$model = new $modelName;
			$model->created_date = date('Y-m-d H:i:s');
			$model->status = 'Created';
		}
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$modelName])) {
			$model->attributes = $_POST[$modelName];
			
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
	
	public function actionPreview($id) {
		
		$this->pageTitle = Yii::app()->name . ' - Preview Email Campaign';
		
		$model = EmailCampaign::model()->findByPk($id);
		
		$this->render('preview', array(
			'model'=>$model,
		));
	}
	
	public function actionPreviewContent($id, $contact_id=null) {
				
		$model = EmailCampaign::model()->findByPk($id);
		
		$fields = array('model'=>$model);
		$contactModel = Yii::app()->getModule('contact')->contactModel;
		
		if ($contact_id)
			$contact = NActiveRecord::model($contactModel)->findByPk($contact_id);
		
		if (isset($contact))
			$fields['contact'] = $contact;
		
		$this->renderPartial('preview/content', $fields);
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

