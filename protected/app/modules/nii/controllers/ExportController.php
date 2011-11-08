<?php

class ExportController extends Controller {

	public function actionDownload($filename=null) {
		
		$content = file_get_contents(Yii::getPathOfAlias('base').'/../files/'.$filename);
		Yii::app()->getRequest()->sendFile($filename, $content);
	}

	/**
	 * Allows the user to select which columns to export to CSV.
	 */
	public function actionDialog($model='Contact', $controller='contact', $action='index', $model_id=null, $scope=null) {
		
		$className = $model;
		$model = new $model;
		$this->render('export_settings',array(
			'model'=>$model,
			'controller'=>$controller,
			'action'=>$action,
			'className'=>$className,
			'model_id'=>$model_id,
			'scope'=>$scope,
			'fileType'=>$fileType
		));
	}
	

	/**
	 * Allows the user to update their settings.
	 */
	public function actionProcess($model='Contact', $controller='contact', $action='index', $fileType='csv', $model_id=null, $scope=null) {
		
		$settingName = $controller.'/'.$action;
		
		$setting = Setting::model()->findByAttributes(
			array(
				'type'=>'export_columns',
				'setting_name'=>$settingName,
				'user_id'=>Yii::app()->user->record->id,
			)
		);
		
		if (!$setting) {
			$setting = new Setting;
			$setting->user_id = Yii::app()->user->record->id;
			$setting->type = 'export_columns';
			$setting->setting_name = $settingName;
		}
		
		$setting->setting_value = str_replace('__', '.', CJSON::encode($_POST['field']));

		if ($setting->save()) {
					
			/*
			 * Process the CSV
			 */
			$className = $model;
			$model = new $model('search');
			
			$model->unsetAttributes();
					
			if(isset($_REQUEST[$className]))
				$model->attributes = $_REQUEST[$className];
			
			if ($model_id && $model_id != '')
				$dataProvider = $model->search($model_id);
			else
				$dataProvider = $model->search();				
			
//			print_r($dataProvider); exit;
			
			$filename = $controller.ucfirst($action).'_export_'.date('YmdHis');
			
			switch($fileType) {
				case "csv" :
					
					$filename = $filename.'.csv';
					
					// CSV content
					$content = $this->widget('nii.widgets.NExportView',array(
							'dataProvider'=>$dataProvider,
							'columns'=>$model->columns(Setting::exportColumns($className, $controller, $action)),
					),true);
					
					// Output file to server for retrieval later
					$success = @file_put_contents(Yii::getPathOfAlias('base').'/../files/'.$filename, $content);
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
							'columns'=>$model->columns(Setting::exportColumns($className, $controller, $action)),
							'fileType'=>$fileType,
					))->renderItems($fileType);

//					print_r($data); exit;
					Yii::import('nii.extensions.phpexcel.JPhpExcel');
					$xls = new JPhpExcel('UTF-8', false, 'My Test Sheet');
					$xls->addArray($data);
					$content = $xls->generateXML();
					// Output file to server for retrieval later
					$success = @file_put_contents(Yii::getPathOfAlias('base').'/../files/'.$filename, $content);
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
							'columns'=>$model->columns(Setting::exportColumns($className, $controller, $action)),
							'fileType'=>$fileType,
					))->renderItems($fileType);				
					saveOds($ods,Yii::getPathOfAlias('base').'/../files/'.$filename);
					if(file_exists(Yii::getPathOfAlias('base').'/../files/'.$filename))
						echo CJSON::encode(array('success'=>'Exporting to ODS','filename'=>$filename,'data'=>$dataProvider->getData()));
					else
						echo CJSON::encode(array('error'=>'Error saving ODS file'));
					
				break;
			}		
			
			Log::insertLog('Exported grid as '.$fileType.' file', $model);
			
			
		}
		
		exit;
	}	
	
}