<?php

class AdminController extends AController {

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {
		
		//$this->actionsMenu = $this->contactGridActions();
		
		$contactModel = Yii::app()->getModule('contact')->contactModel;
		$model = new $contactModel('search');
		
		$model->unsetAttributes();
		
		if(isset($_GET[$contactModel]))
			$model->attributes = $_GET[$contactModel];

		$this->render('grids/allcontacts', array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
	}
			
	/**
	 * View contact details
	 * @param int $id
	 * @param string $selectedTab 
	 */
	public function actionView($id=null, $selectedTab=null) {
		
		$this->pageTitle = Yii::app()->name . ' - View Contact';
		
		$contactModel = Yii::app()->getModule('contact')->contactModel;
				
		$model = NActiveRecord::model($contactModel)->findByPk($id);
		
		$this->checkModelExists($model, "<strong>No contact exists for ID: ".$id."</strong>");
		
		$model->selectedTab = $selectedTab;
		
		$viewData = array(
			'model'=>$model,
		);
		
		$e = new CEvent($this, $viewData);
		$this->render('view', array_merge($viewData, array('event'=>$e)));
		
	}
	
	
	/**
	 * Create a contact
	 * @param string $type 
	 */
	public function actionCreate($type=null, $dialog=null) {
		
		$this->pageTitle = Yii::app()->name . ' - Create a Contact';
		
		$this->breadcrumbs = array(
			'Contact' => array('index'),
			'Create Contact'
		);	
		
		$contactModel = Yii::app()->getModule('contact')->contactModel;
		
		$model = new $contactModel;
		
		if ($type)
			$model->scenario = $type;

		$this->performAjaxValidation($model);
		
		if (isset($_POST[$contactModel])) {
			$model->attributes = $_POST[$contactModel];
			
			if ($model->contact_type == 'Person') 
				$model->name = $model->salutation . ' ' . $model->lastname;
			else
				$model->name = $model->company_name;
			
			if ($model->save()) {
				
				NLog::insertLog('Inserted new contact details: '.$model->name.' (id: '.$model->id.')', $model);
				
				if ($model->photoID) {
					$a = new Attachment;

					$a->file_id = $model->photoID;
					$a->model = $contactModel;
					$a->model_id = $model->id;
					$a->type = 'contact-thumbnail';
					if ($a->save()) {		
						NLog::insertLog('Added a contact thumnail for '.$model->name.' (id: '.$model->id.')', $a);
					} else {
						FB::log(CJSON::encode(array('error'=>'Couldn\'t save attachment.')));
						Yii::app()->end();	
					}
				}
				
				FB::log(CJSON::encode(array('save'=>'Contact saved successfully.')));
				$this->redirect(array("view","id"=>$model->id));		
			}	
		}
		
		if ($type===null)
			$type = 'none';
		
		$viewData = array(
			'c'=>$model,
			'type'=>$type,
			'dialog'=>$dialog,
		);

		$e = new CEvent($this, $viewData);

		if ($model) {
			$this->render('create', array_merge($viewData, array('event'=>$e)));
		} else {
			throw new CHttpException("Couldn't load model '$contactModel'");
		}
		
	}
	
	/**
	 * Edit action
	 * 
	 * @param int $id 
	 */
	public function actionEdit($id=null) {

		$this->pageTitle = Yii::app()->name . ' - Edit Contact';		
		
		$contactModel = Yii::app()->getModule('contact')->contactModel;
		
		$model = NActiveRecord::model($contactModel)->findByPk($id);

		$this->checkModelExists($model, "<strong>No contact exists for ID: ".$id."</strong>");
	
		$model->scenario = $model->contact_type;
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$contactModel])) {
			$model->attributes = $_POST[$contactModel];
			
			if ($model->contact_type == 'Person') 
				$model->name = $model->givennames . ' ' . $model->lastname;
			else
				$model->name = $model->company_name;
			
			FB::log($model->attributes,'$contactModel model');

			if ($model->save()) {
				
				// If it saves, add the attachment
				if ($model->photoID) {

					$a = NAttachment::model()->findByAttributes(array('model_id'=>$model->id,'type'=>'contact-thumbnail'));
					
					if ($model->photoID == '-1') {
						$a->delete();
					} else {
						if ($a === null)
							$a = new NAttachment;

						$a->file_id = $model->photoID;
						$a->model = '$contactModel';
						$a->model_id = $model->id;
						$a->type = 'contact-thumbnail';
						if ($a->save()) {
							NLog::insertLog('Added a contact thumnail for '.$model->name.' (id: '.$model->id.')', $a);
						} else {
							echo CJSON::encode(array('error'=>'Couldn\'t save attachment.'));
							Yii::app()->end();		
						}
					}
				}
				NLog::insertLog('Updated contact details for '.$model->name.' (id: '.$model->id.')', $model);
//				echo CJSON::encode(array('save'=>'Contact saved successfully.'));
				$this->redirect(array("view","id"=>$model->id));		
			} 		
		}
		
		$viewData = array(
			'c'=>$model,
		);

		$e = new CEvent($this, $viewData);
		
		if ($model) {
			$this->render('edit', array_merge($viewData, array('event'=>$e)));
		} else {
			throw new CHttpException("Couldn't load model '$contactModel'");
		}
		
	}
	
	/**
	 * Upload a contact photo
	 */
	public function actionUploadPhoto() {

		$upload = Yii::app()->fileManager;
		$newFileId = $upload->saveFile();
				
		echo $newFileId;
		exit;

	}
	
	public function actionGeneralInfo($id) {

		$contactModel = Yii::app()->getModule('contact')->contactModel;
		$model = NActiveRecord::model($contactModel)->findByPk($id);
		
		$this->render('view/tabs/general',array(
			'model'=>$model,
		));

	}
	
	/**
	 * @param type $id
	 */
	public function actionNotes($id) {

		$contactModel = Yii::app()->getModule('contact')->contactModel;
		$model = NActiveRecord::model($contactModel)->findByPk($id);
		if ($model) {
			$this->render('view/tabs/notes',array(
				'model'=>$model,
				'id'=>$model->id,
			));
		}
	}

	/**
	 * @param type $id
	 */
	public function actionAttachments($id) {

		$contactModel = Yii::app()->getModule('contact')->contactModel;
		$model = NActiveRecord::model($contactModel)->findByPk($id);
		if ($model) {
			$this->render('view/tabs/attachments',array(
				'model'=>$model,
				'id'=>$model->id,
			));
		}
	}
	
	public function actionAddRelationship($id) {
		
		$contactModel = Yii::app()->getModule('contact')->contactModel;
		$model = NActiveRecord::model($contactModel)->findByPk($id);

		if ($model) {
			$this->render('dialog/addRelationship',array(
				'c'=>$model,
			));
		} else {
			throw new CHttpException("Couldn't load model 'Contact'");
		}
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	public function performAjaxValidation($model,$class='contact')
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===$class.'Form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function contactGridActions() {
		return THelper::checkAccess(
			array(
				array('label' => '<span class="icon fam-add">'.$this->t('Add a Person').'</span>', 'url' => array('/contact/create/type/Person')),
				array('label' => '<span class="icon fam-add">'.$this->t('Add an Organisation').'</span>', 'url' => array('/contact/create/type/Organisation')),
			)
		);
	}
	
	public function actionRemove($id) {
		$contactModel = Yii::app()->getModule('contact')->contactModel;
		$model = NActiveRecord::model($contactModel)->findByPk($id);
		if ($model->remove())
			echo 'Success';
	}
	
	public function actionConvertCategories() {
		
		$contacts = Yii::app()->db->createCommand("SELECT id, source_id FROM contact_contact ORDER BY id DESC")->query();

		foreach ($contacts as $c) {
			Yii::app()->db->createCommand("INSERT INTO nii_tag_link (tag_id, model, model_id) VALUES ('".$c['source_id']."', 'HftContact', '".$c['id']."')")->execute();
		}
	}

}