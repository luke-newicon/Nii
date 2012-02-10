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
		
	public function actionCreate() {
		
		$this->pageTitle = Yii::app()->name . ' - Create a New Group';
		
		$modelName = 'ContactGroup';
		$model = new $modelName;
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$modelName])) {
			$model->attributes = $_POST[$modelName];
			
			if ($model->save()) {
				NLog::insertLog('Created a new contact group: '.$model->name.' (id: '.$model->id.')', $model);
				$this->redirect(array("view","id"=>$model->id));	
			}
		
		}
		
		$this->render('edit',array(
			'model'=>$model,
			'action'=>'create',
		));
	}
	
	public function actionEdit($id) {
		
		$this->pageTitle = Yii::app()->name . ' - Create a New Group';
		
		$modelName = 'ContactGroup';
		$model = NActiveRecord::model($modelName)->findByPk($id);
		
		$this->performAjaxValidation($model);
		
		if (isset($_POST[$modelName])) {
			$model->attributes = $_POST[$modelName];
			
			if ($model->save()) {
				NLog::insertLog('Updated contact group '.$model->name.' (id: '.$model->id.')', $model);
				$this->redirect(array("view","id"=>$id));
			}
		
		}
		
		$this->render('edit',array(
			'model'=>$model,
			'action'=>'edit',
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
		
		$ruleModel = new ContactGroupRule;
		$group = NActiveRecord::model('ContactGroup')->findByPk($id);

		$this->render('view/rules',array(
			'dataProvider'=>$model->searchGroupContacts($id, 'rule_based'),
			'model'=>$model,
			'group' => $group,
			'ruleModel'=>$ruleModel,
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
	
	public function actionAddRule($count) {
		$ruleModel = new ContactGroupRule;
		$this->renderPartial('view/rules/_newRule',array(
			'ruleModel'=>$ruleModel,
			'count'=>$count,
		));	
	}
	
	
	/**
	 * @todo: write full comments about this function
	 * @param string $model
	 * @param string $grouping
	 * @param int $id 
	 */
	public function actionAjaxRuleField($grouping=null, $id=null) {
		
		$ruleModel = new ContactGroupRule;
		$this->renderPartial('view/rules/_ruleField',array(
			'ruleModel'=>$ruleModel,
			'grouping'=>$grouping,
			'count'=>$id,
		));	
	}
		
	/**
	 * @todo: write full comments about this function
	 * @param string $model
	 * @param string $grouping
	 * @param int $id 
	 */
	public function actionAjaxRuleSearchBox($grouping=null, $field=null, $id=null) {
		
		$ruleModel = new ContactGroupRule;
		$this->renderPartial('view/rules/_ruleSearchBox',array(
			'ruleModel'=>$ruleModel,
			'grouping'=>$grouping,
			'field'=>$field,
			'count'=>$id,
		));	
	}
	
	public function actionSaveGroupRules($id) {
		$group = NActiveRecord::model('ContactGroup')->findByPk($id);
		$group->filterScopes = CJSON::encode($_POST);
		FB::log($group->filterScopes);
		$group->save();
		Yii::app()->user->setFlash('success',$this->t("Your rules were successfully saved."));
		$this->redirect(array('/contact/group/view/id/'.$id.'#Rules'));
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

