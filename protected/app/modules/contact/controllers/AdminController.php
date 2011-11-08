<?php

class AdminController extends AController {

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {
		
		//$this->actionsMenu = $this->contactGridActions();
		
//		$this->pageTitle = Yii::app()->name . ' - All Contacts';
		
		$contacts = 'Contact';
		$model = new Contact('search');
		
		$model->unsetAttributes();
		
		if(isset($_GET[$contacts]))
			$model->attributes = $_GET[$contacts];

		$this->render('grids/allcontacts',array(
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
				
		$model = Contact::model()->findByPk($id);
		
		$this->checkModelExists($model, "<strong>No contact exists for ID: ".$id."</strong>");
		
//		if (THelper::checkAccess()) {
//			$this->actionsMenu = array(
//				array('label' => '<span class="icon fam-user-edit">'.$this->t('Edit Contact').'</span>', 'url' => array('/contact/edit','id'=>$id)),
//				array('label' => '<span class="icon fam-user-add">'.$this->t('Add Relationship').'</span>', 'url' => '#',
//					'linkOptions'=>array(
//						'onclick'=> $model->addRelationshipDialog()
//					)
//				),
//			);
//
//			// If the contact has student details, include the menu link for adding a programme
//			if ($student) {
//				array_push ($this->actionsMenu, 
//					array(
//						'label' => '<span class="icon fam-page-add">'.$this->t('Add Programme of Study').'</span>', 
//						'url' => '#',
//						'linkOptions'=>array(
//							'onclick'=> $model->addProgrammeDialog($id)
//						)
//					)
//				);
//			}
//		}
		
		$model->selectedTab = $selectedTab;
		
		$this->render('view',array(
			'model'=>$model,
		));
		
	}
	/**
	 * Create a contact
	 * @param string $type 
	 */
	public function actionCreate($type=null) {
		
		$this->breadcrumbs = array(
			'Contact' => array('index'),
			'Create Contact'
		);	
			
		$model = new Contact;
		
		if ($type)
			$model->scenario = $type;

		$this->performAjaxValidation($model);
		
		if ($_POST['Contact']) {
			$model->attributes = $_POST['Contact'];
			
			if ($model->contact_type == 'Person') 
				$model->name = $model->salutation . ' ' . $model->lastname;
			else
				$model->name = $model->company_name;
			
			if ($model->save()) {
				
				Log::insertLog('Inserted new contact details: '.$model->name.' (id: '.$model->id.')', $model);
				
				if ($model->photoID) {
					$a = new Attachment;

					$a->file_id = $model->photoID;
					$a->model = 'Contact';
					$a->model_id = $model->id;
					$a->type = 'contact-thumbnail';
					if ($a->save()) {		
						Log::insertLog('Added a contact thumnail for '.$model->name.' (id: '.$model->id.')', $a);
					} else {
						FB::log(CJSON::encode(array('error'=>'Couldn\'t save attachment.')));
						Yii::app()->end();	
					}
				}
				
				FB::log(CJSON::encode(array('save'=>'Contact saved successfully.')));
				$this->redirect(array("contact/view","id"=>$model->id));		
			}	
		}
		
		if ($type===null)
			$type = 'none';

		if ($model) {
			$this->render('create',array(
				'c'=>$model,
				'type'=>$type,
			));
		} else {
			throw new CHttpException("Couldn't load model 'Contact'");
		}
		
	}
	
	/**
	 * Edit action
	 * 
	 * @param int $id 
	 */
	public function actionEdit($id=null) {
		
			
		$model = Contact::model()->findByPk($id);			
		$model->scenario = $model->contact_type;
		
		$this->performAjaxValidation($model);
		
		if ($_POST['Contact']) {
			$model->attributes = $_POST['Contact'];
			
			if ($model->contact_type == 'Person') 
				$model->name = $model->givennames . ' ' . $model->lastname;
			else
				$model->name = $model->company_name;
			
			FB::log($model->attributes,'Contact model');

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
						$a->model = 'Contact';
						$a->model_id = $model->id;
						$a->type = 'contact-thumbnail';
						if ($a->save()) {
							Log::insertLog('Added a contact thumnail for '.$model->name.' (id: '.$model->id.')', $a);
						} else {
							echo CJSON::encode(array('error'=>'Couldn\'t save attachment.'));
							Yii::app()->end();		
						}
					}
				}
				Log::insertLog('Updated contact details for '.$model->name.' (id: '.$model->id.')', $model);
//				echo CJSON::encode(array('save'=>'Contact saved successfully.'));
				$this->redirect(array("admin/view","id"=>$model->id));		
			} 		
		}


		if ($model) {
			$this->render('edit',array(
				'c'=>$model,
			));
		} else {
			throw new CHttpException("Couldn't load model 'Contact'");
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

		$model = Contact::model()->findByPk($id);
		
		$this->render('view/tabs/general',array(
			'model'=>$model,
		));

	}

	public function actionStudentDetails($cid,$mode=null) {

		$class = 'Student';
		$student = CActiveRecord::model($class)->findByAttributes(array('contact_id'=>$cid));
		if ($student && $mode == 'edit') {
			$action = 'edit';
		} else if ($student === null) {
			$student = new $class;
			$action = 'create';
		} else {
			$action = 'view';
		}
		
		if ($action != 'view') {
			$this->performAjaxValidation($student,  strtolower($class));
		}
		
		if ($_POST[$class]) {
			$student->attributes = $_POST[$class];
			$student->contact_id = $cid;
			
			if ($student->save()) {
				
				$contact = Contact::model()->findByPk($cid);
				if ($action=='edit')
					Log::insertLog('Updated student details for '.$contact->name.' (id: '.$contact->id.')', $student);
				else
					Log::insertLog('Inserted new student details for '.$contact->name.' (id: '.$contact->id.')', $student);					
				
				echo CJSON::encode(array('success'=>'Saved student details', 'sid'=>$student->id));
				exit;
			}
		}		
		
		if ($student) {
			$this->render('view/tabs/student',array(
				's'=>$student,
				'action'=>$action,
				'cid'=>$cid,
			));
		}		

	}
	
	public function actionStudentProgrammeList($cid) {
		
		$class = 'StudentProgrammes';
		$student_id = Contact::model()->findByPk($cid)->student->id;
		
		$model = new StudentProgrammes('search');	

		$model->unsetAttributes();		
		$model->student_id = $student_id;
		
		if(isset($_GET[$class]))
			$model->attributes = $_GET[$class];

		$this->render('grids/programmes',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
			'cid'=>$cid,
		));
	}
	
	
	public function actionAddProgrammeDetails($cid,$pid) {

		$class = 'Study';
		$s = new $class;

		$p = Programme::model()->findByPk($pid);
	
		$this->performAjaxValidation($p,  strtolower($class));

		if ($_POST[$class]) {
			$s->attributes = $_POST[$class];
			$s->contact_id = $cid;
			
			if ($s->save()) {
				
				echo CJSON::encode(array('success'=>'Saved programme details', 'pid'=>$s->id));
				exit;
			} 
		}
		
		
		if ($s) {
			$this->render('view/tabs/programme',array(
				's'=>$s,
				'p'=>$p,
				'action'=>'create',
				'pid'=>$pid,
				'cid'=>$cid,
			));
		}		

	}
	
	public function actionAcademicDetails($cid, $mode=null) {

		$class = 'Academic';
		$model = CActiveRecord::model($class)->findByAttributes(array('contact_id'=>$cid));
		if ($model && $mode == 'edit') {
			$action = 'edit';
		} else if ($model === null) {
			$model = new $class;
			$action = 'create';
		} else {
			$action = 'view';
		}
		
		if ($action != 'view') {
			$this->performAjaxValidation($model,  strtolower($class));
		}
		
		if ($_POST[$class]) {
			$model->attributes = $_POST[$class];
			$model->contact_id = $cid;
			
			if ($model->save()) {
				
				$contact = Contact::model()->findByPk($cid);
				if ($action=='edit')
					Log::insertLog('Updated academic details for '.$contact->name.' (id: '.$contact->id.')', $model);
				else
					Log::insertLog('Inserted new academic details for '.$contact->name.' (id: '.$contact->id.')', $model);							
				
				echo CJSON::encode(array('success'=>'Saved academic details', 'sid'=>$model->id));
				exit;
			}
		}		
		
		if ($model) {
			$this->render('view/tabs/academic',array(
				'model'=>$model,
				'action'=>$action,
				'cid'=>$cid,
			));
		}	
	}
	
	/**
	 * Tab for editing/viewing contact's church details
	 * @param int $cid
	 * @param string $mode 
	 */
	public function actionChurchDetails($cid, $mode=null) {

		$class = 'Church';
		$model = CActiveRecord::model($class)->findByAttributes(array('contact_id'=>$cid));
		if ($model && $mode == 'edit') {
			$action = 'edit';
		} else if ($model === null) {
			$model = new $class;
			$action = 'create';
		} else {
			$action = 'view';
		}
		
		if ($action != 'view') {
			$this->performAjaxValidation($model,  strtolower($class));
		}
		
		if ($_POST[$class]) {
			$model->attributes = $_POST[$class];
			$model->contact_id = $cid;
			
			if ($model->save()) {
				
				$contact = Contact::model()->findByPk($cid);
				if ($action=='edit')
					Log::insertLog('Updated church details for '.$contact->name.' (id: '.$contact->id.')', $model);
				else
					Log::insertLog('Inserted new church details for '.$contact->name.' (id: '.$contact->id.')', $model);		
				
				echo CJSON::encode(array('success'=>'Saved church details', 'sid'=>$model->id));
				exit;
			}
		}		
		
		if ($model) {
			$this->render('view/tabs/church',array(
				'model'=>$model,
				'action'=>$action,
				'cid'=>$cid,
			));
		}	
	}
	
	/**
	 * Tab for editing/viewing contact's diocese details
	 * @param int $cid
	 * @param string $mode 
	 */
	public function actionDioceseDetails($cid, $mode=null) {

		$class = 'Diocese';
		$model = CActiveRecord::model($class)->findByAttributes(array('contact_id'=>$cid));
		if ($model && $mode == 'edit') {
			$action = 'edit';
		} else if ($model === null) {
			$model = new $class;
			$action = 'create';
		} else {
			$action = 'view';
		}
		
		if ($action != 'view') {
			$this->performAjaxValidation($model,  strtolower($class));
		}
		
		if ($_POST[$class]) {
			$model->attributes = $_POST[$class];
			$model->contact_id = $cid;
			
			if ($model->save()) {
				
				$contact = Contact::model()->findByPk($cid);
				if ($action=='edit')
					Log::insertLog('Updated diocese details for '.$contact->name.' (id: '.$contact->id.')', $model);
				else
					Log::insertLog('Inserted new diocese details for '.$contact->name.' (id: '.$contact->id.')', $model);		
	
				echo CJSON::encode(array('success'=>'Saved diocese details', 'sid'=>$model->id));
				exit;
			}
		}		
		
		if ($model) {
			$this->render('view/tabs/diocese',array(
				'model'=>$model,
				'action'=>$action,
				'cid'=>$cid,
			));
		}	
	}
	
	public function actionStaffDetails($cid, $mode=null) {

		$class = 'Staff';
		$model = CActiveRecord::model($class)->findByAttributes(array('contact_id'=>$cid));
		if ($model && $mode == 'edit') {
			$action = 'edit';
		} else if ($model === null) {
			$model = new $class;
			$action = 'create';
		} else {
			$action = 'view';
		}
		
		if ($action != 'view') {
			$this->performAjaxValidation($model,  strtolower($class));
		}
		
		if ($_POST[$class]) {
			$model->attributes = $_POST[$class];
			$model->contact_id = $cid;
			
			if ($model->save()) {
				
				$contact = Contact::model()->findByPk($cid);
				if ($action=='edit')
					Log::insertLog('Updated staff details for '.$contact->name.' (id: '.$contact->id.')', $model);
				else
					Log::insertLog('Inserted new staff details for '.$contact->name.' (id: '.$contact->id.')', $model);		
					
				echo CJSON::encode(array('success'=>'Saved staff details', 'id'=>$model->id));
				exit;
			}
		}		
		
		if ($model) {
			$this->render('view/tabs/staff',array(
				'model'=>$model,
				'action'=>$action,
				'cid'=>$cid,
			));
		}	
	}
	
	public function actionClericDetails($cid, $mode=null) {

		$class = 'Cleric';
		$model = CActiveRecord::model($class)->findByAttributes(array('contact_id'=>$cid));
		if ($model && $mode == 'edit') {
			$action = 'edit';
		} else if ($model === null) {
			$model = new $class;
			$action = 'create';
		} else {
			$action = 'view';
		}
		
		if ($action != 'view') {
			$this->performAjaxValidation($model,  strtolower($class));
		}
		
		if ($_POST[$class]) {
			$model->attributes = $_POST[$class];
			$model->contact_id = $cid;
			
			if ($model->save()) {
				
				$contact = Contact::model()->findByPk($cid);
				if ($action=='edit')
					Log::insertLog('Updated cleric details for '.$contact->name.' (id: '.$contact->id.')', $model);
				else
					Log::insertLog('Inserted new cleric details for '.$contact->name.' (id: '.$contact->id.')', $model);		
	
				echo CJSON::encode(array('success'=>'Saved cleric details', 'id'=>$model->id));
				exit;
			}
		}		
		
		if ($model) {
			$this->render('view/tabs/cleric',array(
				'model'=>$model,
				'action'=>$action,
				'cid'=>$cid,
			));
		}	

	}
	
	public function actionTrainingfacilityDetails($cid, $mode=null) {

		$class = 'Trainingfacility';
		$model = CActiveRecord::model($class)->findByAttributes(array('contact_id'=>$cid));
		if ($model && $mode == 'edit') {
			$action = 'edit';
		} else if ($model === null) {
			$model = new $class;
			$action = 'create';
		} else {
			$action = 'view';
		}
		
		if ($action != 'view') {
			$this->performAjaxValidation($model,  strtolower($class));
		}
		
		if ($_POST[$class]) {
			$model->attributes = $_POST[$class];
			$model->contact_id = $cid;
			
			if ($model->save()) {
				
				$contact = Contact::model()->findByPk($cid);
				if ($action=='edit')
					Log::insertLog('Updated training facility details for '.$contact->name.' (id: '.$contact->id.')', $model);
				else
					Log::insertLog('Inserted new training facility details for '.$contact->name.' (id: '.$contact->id.')', $model);		
	
				echo CJSON::encode(array('success'=>'Saved facility details', 'id'=>$model->id));
				exit;
			}
		}		
		
		if ($model) {
			$this->render('view/tabs/trainingfacility',array(
				'model'=>$model,
				'action'=>$action,
				'cid'=>$cid,
			));
		}	
	}
	
	public function actionComputerUserDetails($cid, $mode=null) {

		$class = 'ComputerUser';
		$model = new $class;
		
		$contact = Contact::model()->findByPk($cid);
		$student_id = $contact->student->id;
		
		Yii::app()->ldap->rootIdField = 'cn';
		Yii::app()->ldap->dnPrefix = 'ou=TrinityStudentLogins';
		$ldap = Yii::app()->ldap->search('(sn='.$student_id.')',array('sn','uid','cn'));
		
		if ($ldap) {
			if ($mode===null)
				$mode='view';
			
			$fields = $ldap[0];
			$model->sn = $fields['sn'];
			$model->uid = $fields['uid'];
			$model->cn = $fields['cn'];
		} else if ($ldap === null) {
			$mode = 'create';
		}
		
		if ($mode != 'view') {
			$this->performAjaxValidation($model, strtolower($class));
		}
		
		if ($_POST[$class]) {
			$model->attributes = $_POST[$class];
			
			if ($model->createComputerUser()) {
				
				Log::insertLog('Inserted new computer user details for '.$contact->name.' (id: '.$cid.')', $contact);											
				echo CJSON::encode(array('success'=>'Saved computer user details'));
				exit;
			}
		}		
		
		if ($model) {
			$this->render('view/tabs/computeruser',array(
				'model'=>$model,
				'action'=>$mode,
				'cid'=>$cid,
				'student_id'=>$student_id,
				'contact'=>$contact,
			));
		}	
	}
	
/**
	 * @param type $id
	 */
	public function actionNotes($id) {

		$model = Contact::model()->findByPk($id);
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

		$model = Contact::model()->findByPk($id);
		if ($model) {
			$this->render('view/tabs/attachments',array(
				'model'=>$model,
				'id'=>$model->id,
			));
		}
	}
	
	public function actionAddRelationship($id) {
		
		$model = Contact::model()->findByPk($id);

		if ($model) {
			$this->render('dialog/addRelationship',array(
				'c'=>$model,
			));
		} else {
			throw new CHttpException("Couldn't load model 'Contact'");
		}
	}
	
	public function actionAddProgramme($id) {
		
		$model = Contact::model()->findByPk($id);
		$student = Student::model()->findByAttributes(array('contact_id'=>$model->id));

		if ($model) {
			$this->render('dialog/addProgramme',array(
				'model'=>$model,
				'student'=>$student,
			));
		} else {
			throw new CHttpException("Couldn't load model 'Contact'");
		}
	}	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
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
		$model = Contact::model()->findByPk($id);
		if ($model->remove())
			echo 'Success';
	}

}