<?php

class GroupController extends AController
{
	
	public function actionIndex()
	{
		$this->pageTitle = Yii::app()->name . ' - Email Groups';
		$groupModel = 'ContactGroup';
	
		$model = new $groupModel('search');
		$model->unsetAttributes();
		
		if(isset($_GET[$groupModel]))
			$model->attributes = $_GET[$groupModel];

		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));	
		
	}
	
		
	public function actionView($id) {
		
		$this->pageTitle = Yii::app()->name . ' - View Group';
		
		$model = NActiveRecord::model('ContactGroup')->findByPk($id);
		$this->render('view',array(
			'model'=>$model,
		));
	}
	
	public function actionViewContacts($id) {
		$groupModel = 'ContactGroupContactMembers';
	
		$model = new $groupModel('searchGroupContacts');
		$model->unsetAttributes();
		
		if(isset($_GET[$groupModel]))
			$model->attributes = $_GET[$groupModel];
		
		$model->groupId = $id;
		
		$this->render('view/contacts',array(
			'dataProvider'=>$model->searchGroupContacts($id),
			'model'=>$model,
		));	
	}
	
	public function actionViewRules($id) {
		$groupModel = 'ContactGroupContact';
		$contactModel = Yii::app()->getModule('contact')->contactModel;
	
		$model = new $groupModel('searchGroupContacts');
		$model->unsetAttributes();
		
		if(isset($_GET[$groupModel]))
			$model->attributes = $_GET[$groupModel];

		$this->render('view/rules',array(
			'dataProvider'=>$model->searchGroupContacts($id, 'rule_based'),
			'model'=>$model,
		));	
	}
	
	public function actionDeleteMember($id) {
		$m = NActiveRecord::model('ContactGroupContact')->findByPk($id);
		if (NActiveRecord::model('ContactGroupContact')->deleteByPk($id)) {
			$group = NActiveRecord::model('ContactGroup')->findByPk($m->group_id);			
			echo CJSON::encode(array('success'=>'Successfully deleted a member', 'count'=>$group->countGroupContacts('user_defined'), 'countTotal'=>$group->countGroupContacts()));
		}
	}
	
	public function actionAddMember($groupId) {
		$modelName = 'ContactGroupContactMembers';
		
		$model = new $modelName;
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$modelName])) {
			$model->attributes = $_POST[$modelName];
						
			if ($model->save()) {
				$group = NActiveRecord::model('ContactGroup')->findByPk($groupId);
				echo CJSON::encode(array('success'=>'Successfully added a member', 'count'=>$group->countGroupContacts('user_defined'), 'countTotal'=>$group->countGroupContacts()));
			}
		}
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

