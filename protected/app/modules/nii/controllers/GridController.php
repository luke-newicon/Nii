<?php

/**
 * GridController is used for all general functions related to a grid,
 * such as setting which columns to show, exporting data and working
 * with custom scopes
 * 
 * It is as generic as possible and mainly uses the grid ID and model as the identifiers
 * for the various function
 *
 * @author robinwilliams
 */

class GridController extends AController {

	/**
	 *	Display the dialog that allows the user to update their grid column settings.
	 * 
	 * @param model $model
	 * @param string $gridId 
	 */
	public function actionGridSettingsDialog($model, $gridId) {
		
		$model = new $model;
		$this->render('grid_settings',array(
			'model'=>$model,
			'gridId'=>$gridId,
		));
	}
	
	/**
	 *	Process the grid column settings changes using POST data from a form
	 * 
	 * @param string $key 
	 */
	public function actionUpdateGridSettings($key) {
		
		$values = $_POST;
		
		Yii::app()->user->settings->set('grid_columns_'.$key,$values);
		
		echo CJSON::encode(array('success'=>'Columns updated successfully'));

		Yii::app()->end();
	}	
	
	/**
	 *	Display the custom scope dialog
	 * 
	 * @param model $model
	 * @param string $controller
	 * @param string $action
	 * @param int $id 
	 */
	public function actionCustomScopeDialog($gridId, $model, $id=null) {
		
		$className = $model;
		$model = new $model;

		$columns = $model->columns(array());
		$fields[''] = 'select field...';
		foreach ($columns as $column) {
			if ($column['name'])
				$fields[$column['name']] = $model->getAttributeLabel($column['name']);
		}
		
		$filterModel = new NCustomScope;
		
		$renderArray = array(
			'cs'=>$filterModel,
			'fields'=>$fields,
			'className'=>$className,
			'model'=>$model,
			'gridId'=>$gridId,
		);
		
		if ($id) {
			$scopes = Yii::app()->user->settings->get('custom_scope_'.$gridId);
			$scope = $scopes[$id];
			$renderArray['scope'] = $scope;
			$renderArray['scopeId'] = $id;
			$renderArray['formAction'] = 'edit';
		} else {
			$renderArray['scope'] = '';
			$renderArray['formAction'] = 'create';
		}
			
		$this->render('custom_scope', $renderArray);
	}
	

	/**
	 * Allows the user to create or update a custom scope.
	 * 
	 * @param string $gridId 
	 * @param int $scopeId 
	 */
	public function actionUpdateCustomScope($gridId, $scopeId=null) {
				
		$key = 'custom_scope_'.$gridId;
		$scopes = Yii::app()->user->settings->get($key, array());
				
		if (!$scopeId) {
			$scopeId = count($scopes)+1;
		}
		
		$scopes[$scopeId] = $_POST;
		
		if (Yii::app()->user->settings->set($key, $scopes))
			echo CJSON::encode(array('success'=>'Custom scope '.($scopeId?'updated':'added')));
		else
			echo CJSON::encode(array('failed'=>'Failed to save'));
		Yii::app()->end();
	}	
	
	/**
	 *	Delete a custom scope
	 * @param int $id 
	 */	
	public function actionDeleteCustomScope($id, $gridId) {
		
		$key = 'custom_scope_'.$gridId;
		$scopes = Yii::app()->user->settings->get($key, array());
		unset($scopes[$id]);
		$success = Yii::app()->user->settings->set($key, $scopes);
		if ($success) {
			echo CJSON::encode(array('success'=>'Custom scope deleted'));
		}
	}
	
	/**
	 *	Action to create a new custom scope via ajax
	 * @param model $model
	 * @param int $count 
	 */
	public function actionAjaxNewCustomScope($model, $count) {
	
		$model = new $model;

		$columns = $model->columns(array());
		$fields[''] = 'select field...';
		foreach ($columns as $column) {
			if ($column['name'])
				$fields[$column['name']] = $model->getAttributeLabel($column['name']);
		}
		
		$filterModel = new NCustomScope;
		
		$this->render('ajax/_new_custom_scope',array(
			'model'=>$model,
			'fields'=>$fields,
			'count'=>$count,
		));	
		
	}
	
	public function actionAjaxUpdateCustomScopeValueBlock($model=null, $field=null, $id=null) {
		$this->renderPartial('ajax/_filter_fields', array('model'=>$model, 'field'=>$field, 'id'=>$id));
	}
	
	/**
	 *	Export Functions
	 */
	
	
	/**
	 *	Download exported file
	 * @param string $filename 
	 */
	public function actionExportDownload($filename=null) {
		
		$content = file_get_contents(Yii::getPathOfAlias('public').'/../files/'.$filename);
		Yii::app()->getRequest()->sendFile($filename, $content);
	}

	/**
	 *	Render a dialog box that allows the user to select which columns to export to CSV.
	 * 
	 * @param model $model
	 * @param string $gridId
	 * @param int $model_id
	 * @param string $scope 
	 */
	public function actionExportDialog($model='Contact', $gridId=null, $model_id=null, $scope=null) {
		
		$className = $model;
		$model = new $model;
		$this->render('export_settings',array(
			'model'=>$model,
			'className'=>$className,
			'gridId'=>$gridId,
			'model_id'=>$model_id,
			'scope'=>$scope,
		));
	}
	
	/**
	 * Export the data using the fileType and columns specified by the user and update the user's settings with the selected columns
	 * 
	 * @param model $model
	 * @param string $fileType
	 * @param string $gridId
	 * @param int $model_id
	 * @param string $scope 
	 */
	public function actionExportProcess($model='Contact', $fileType=null, $gridId=null, $model_id=null, $scope=null) {
		
		
		$columns = $_POST['field'];
		
		// Update the user's settings for export_columns on the relevant grid
		Yii::app()->user->settings->set('export_columns_'.$gridId, $columns);

		if ($columns) {
					
			// Gather the required data for the export...
			$className = $model;
			$model = new $model('search');
			
			$model->unsetAttributes();
					
			if(isset($_REQUEST[$className]))
				$model->attributes = $_REQUEST[$className];
			
			if ($model_id && $model_id != '')
				$dataProvider = $model->search($model_id);
			else
				$dataProvider = $model->search();				
			
			$filePath = Yii::getPathOfAlias('public').'/../files/';
			$filename = $gridId.'_export_'.date('YmdHis');
			
			// Process the particular file formats, create the files and file with data
			switch($fileType) {
				case "csv" :
					
					$filename = $filename.'.csv';
					
					// CSV content
					$content = $this->widget('nii.widgets.NExportView',array(
							'dataProvider'=>$dataProvider,
							'columns'=>$model->columns($columns),
					),true);
					
					// Output file to server for retrieval later
					$success = @file_put_contents($filePath.$filename, $content);
					if($success)
						echo CJSON::encode(array('success'=>'Exporting to CSV','filename'=>$filename,'data'=>$dataProvider->getData()));
					else
						echo CJSON::encode(array('error'=>'Error saving CSV file'));
					
				break;
			
				case "excel" :
					
					$filename = $filename.'.xls';
					
					// Excel content
					$data = $this->widget('nii.widgets.NExportView',array(
							'dataProvider'=>$dataProvider,
							'columns'=>$model->columns($columns),
							'fileType'=>$fileType,
					))->renderItems($fileType);

//					print_r($data); exit;
					Yii::import('nii.extensions.phpexcel.JPhpExcel');
					$xls = new JPhpExcel('UTF-8', false, 'My Test Sheet');
					$xls->addArray($data);
					$content = $xls->generateXML();
					// Output file to server for retrieval later
					$success = @file_put_contents($filePath.$filename, $content);
					if($success)
						echo CJSON::encode(array('success'=>'Exporting to Excel','filename'=>$filename,'data'=>$dataProvider->getData()));
					else
						echo CJSON::encode(array('error'=>'Error saving Excel file'));
					
				break;
			
				case "ods" :
					
					$filename = $filename.'.ods';
					
					// Excel content
					require_once (Yii::getPathOfAlias('nii.extensions').DIRECTORY_SEPARATOR.'phpods'.DIRECTORY_SEPARATOR.'ods.php');
					$ods = $this->widget('nii.widgets.NExportView',array(
							'dataProvider'=>$dataProvider,
							'columns'=>$model->columns($columns),
							'fileType'=>$fileType,
					))->renderItems($fileType);				
					saveOds($ods,$filePath.$filename);
					if(file_exists($filePath.$filename))
						echo CJSON::encode(array('success'=>'Exporting to ODS','filename'=>$filename,'data'=>$dataProvider->getData()));
					else
						echo CJSON::encode(array('error'=>'Error saving ODS file'));
					
				break;
			}		
			
			NLog::insertLog('Exported grid as '.$fileType.' file', $model);
			
			
		}
		
		// Run end() to allow the data to return and the settings to be updated
		Yii::app()->end();
	}	
}