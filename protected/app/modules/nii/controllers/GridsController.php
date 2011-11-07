<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GridsController
 *
 * @author robinwilliams
 */
class GridsController extends AController {

	/**
	 * Allows the user to update their settings.
	 */
	public function actionGridSettingsDialog($model='Contact', $controller='contact', $action='index', $gridId) {
		
		$model = new $model;
		$this->render('grid_settings',array(
			'model'=>$model,
			'controller'=>$controller,
			'action'=>$action,
			'gridId'=>$gridId,
		));
	}
	

	/**
	 * Allows the user to update their settings.
	 */
	public function actionUpdateGridSettings($settingName=null) {
		
		
		
		$model = Setting::model()->findByAttributes(
			array(
				'type'=>'grid_columns',
				'setting_name'=>$settingName,
				'user_id'=>Yii::app()->user->record->id,
			)
		);
		
		if (!$model) {
			$model = new Setting;
			$model->user_id = Yii::app()->user->record->id;
			$model->type = 'grid_columns';
			$model->setting_name = $settingName;
		}
		
		$model->setting_value = CJSON::encode($_POST);
		if ($model->save()) {
			echo CJSON::encode(array('success'=>'Columns updated successfully'));
		} else {
			echo CJSON::encode(array('failed'=>$model->attributes));
		}
		exit;
	}	
	
	
	public function actionCustomScopeDialog($model=null,$controller=null,$action=null, $id=null) {
		
		$className = $model;
		$model = new $model;

		$columns = $model->columns(array());
		$fields[''] = 'select field...';
		foreach ($columns as $column) {
			if ($column['name'])
				$fields[$column['name']] = $model->getAttributeLabel($column['name']);
		}
		
		$filterModel = new CustomScope;
		
		$renderArray = array(
			'cs'=>$filterModel,
			'controller'=>$controller,
			'action'=>$action,
			'fields'=>$fields,
			'className'=>$className,
			'model'=>$model,
		);
		
		if ($id) {
			$scope = Setting::model()->findByPk($id);
			$renderArray['scope'] = CJSON::decode($scope->setting_value);
			$renderArray['scopeId'] = $scope->id;
			$renderArray['formAction'] = 'edit';
		} else {
			$renderArray['scope'] = '';
			$renderArray['formAction'] = 'create';
		}
			
		$this->render('custom_scope', $renderArray);
	}
	

	/**
	 * Allows the user to create or update a custom scope.
	 */
	public function actionUpdateCustomScope($gridId, $scopeId=null) {
		
		
		if ($scopeId) {
			$model = Setting::model()->findByPk($scopeId);
		} else {
			$model = new Setting;
			$model->user_id = Yii::app()->user->record->id;
			$model->type = 'custom_scope';
			$model->setting_name = $gridId;
		}
		
		$model->setting_value = CJSON::encode($_POST);
		
		if ($model->save()) {
			echo CJSON::encode(array('success'=>'Custom scope added'));
		} else {
			echo CJSON::encode(array('failed'=>$model->attributes));
		}
		exit;
	}	
	
	public function actionDeleteCustomScope($id) {
		$success = Setting::model()->deleteByPk($id);
		if ($success >=1) {
			echo CJSON::encode(array('success'=>'Custom scope deleted'));
		}
	}
	
	public function actionAjaxNewCustomScope($model, $controller, $action, $count) {
	
		$model = new $model;

		$columns = $model->columns(array());
		$fields[''] = 'select field...';
		foreach ($columns as $column) {
			if ($column['name'])
				$fields[$column['name']] = $model->getAttributeLabel($column['name']);
		}
		
		$filterModel = new CustomScope;
		
		$this->render('ajax/_new_custom_scope',array(
			'model'=>$model,
			'controller'=>$controller,
			'action'=>$action,
			'fields'=>$fields,
			'count'=>$count,
		));	
		
	}
	
	public function actionAjaxUpdateCustomScopeValueBlock($model=null, $field=null, $id=null) {

		
		$this->renderPartial('ajax/_filter_fields', array('model'=>$model, 'field'=>$field, 'id'=>$id));
//		$model = new $model;
//		$filter = '';
//		
//		foreach($model->columns(array()) as $column) {
//			if ($column['name']==$field && is_array($column['filter']))
//				$filter = $column['filter'];
//		}
//		if (is_array($filter))
//			echo CHtml::dropDownList('rule['.$id.'][value]', '', $filter);
//		else
//			echo CHtml::textField('rule['.$id.'][value]');
	}
}