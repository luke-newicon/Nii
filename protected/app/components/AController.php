<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 * Implements a default Deny behaviour
 */
class AController extends NController {

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/admin1column';

	public function init() {
		Yii::app()->errorHandler->errorAction = '/admin/error';

		$this->menu = array(
			'admin' => array('label' => 'Admin', 'url' => array('/admin'), 'active' => ($this->parentActive('admin/index') || $this->parentActive('admin/settings') || $this->parentActive('admin/modules')),
				'items' => array(
					'modules' => array('label' => 'Modules', 'url' => array('/admin/modules/index')),
					'settings' => array('label' => 'Settings', 'url' => array('/admin/settings/index')),
				),
			),
		);
	}

	/**
	 * Provides a default interface for adding actions to controllers
	 * @return array Set of controller actions supplied by the current module
	 */
	public function actions() {
		if (property_exists($this->module, 'actions'))
			return isset($this->module->actions[$this->id]) ? $this->module->actions[$this->id] : array();
	}

	public function active() {
		
	}

	public function parentActive($controller) {
		if ($controller == Yii::app()->controller->uniqueid)
			return true;
	}

	public function accessRules() {
		return array(
			array('allow',
				'expression' => '$user->checkAccessToRoute()',
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	public function updateGridColumns($controller, $action, $model, $buttonOnly=false) {
		if ($buttonOnly) {
			$label = '<span class="icon fam-cog"></span>';
			$options = 'htmlOptions';
		} else {
			$label = '<span class="icon fam-cog"></span>' . $this->t('Update Visible Columns');
			$options = 'linkOptions';
		}
		return array(
			'label' => $label, 'url' => '#',
			$options => array(
				'onclick' => Setting::gridSettingsDialog(array('controller' => $controller, 'action' => $action, 'model' => $model)),
				'title' => $this->t('Update Visible Columns'),
			),
		);
	}

	public function exportGrid($controller, $action, $model, $buttonOnly=false, $model_id=null) {
		if ($buttonOnly) {
			$label = '<span class="icon fam-table-go"></span>';
			$options = 'htmlOptions';
		} else {
			$label = '<span class="icon fam-table-go"></span>' . $this->t('Export to CSV, Excel or ODS');
			$options = 'linkOptions';
		}
		return array(
			'label' => $label, 'url' => '#',
			$options => array(
				'onclick' => Setting::exportGridDialog(array('controller' => $controller, 'action' => $action, 'model' => $model, 'model_id' => $model_id, 'scope' => Yii::app()->request->getQuery('scope'))),
				'title' => $this->t('Export to CSV, Excel or ODS'),
			),
		);
	}

	public static function checkExportCols($model, $col) {
		$replacementCols = array(
			'Student' => array(
				'student.international' => "(CASE WHEN student.international <> 0 THEN 'Y' ELSE 'N' END) as international",
				'dob' => "DATE_FORMAT(dob, '%d %m %Y')",
			),
			'Contact' => array(
				'type' => "TRIM( TRAILING ', ' FROM CONCAT( (CASE WHEN student.id > 0 THEN 'Student, ' ELSE '' END), (CASE WHEN academic.id > 0 THEN 'Academic, ' ELSE '' END) , (CASE WHEN staff.id > 0 THEN 'Staff, ' ELSE '' END), (CASE WHEN cleric.id > 0 THEN 'Cleric, ' ELSE '' END) ) ) as type",
			),
			'Diocese' => array(
				'contact_name' => 'b.name as contact_name'
			),
			'Study' => array(
				'programmeName' => 'programme.name as programmeName',
				'programmeYear' => "CONCAT (study.acyr, ' / ', study.acyr+1) as programmeYear",
				'statusName' => 'status.name as statusName',
			),
		);
		if (is_array($replacementCols[$model])) {
			if (array_key_exists($col, $replacementCols[$model]))
				return $replacementCols[$model][$col];
		}
		return $col;
	}

	public function checkModelExists($model=null, $message=null, $htmlMessage=true) {
		if (isset($model->id))
			return true;
		else {
			if ($message == null)
				$message = 'Could not find a record for specified id';
			$this->render('//site/error', array(
				'message' => $message,
				'htmlMessage' => $htmlMessage,
				'code'=>'404',
			));
		}
		Yii::app()->end();
	}

	/**
	 * @param $str
	 * @param $params
	 * @param $dic
	 * @return string
	 */
	public static function t($str='', $params=array()) {
		return Yii::t(__CLASS__, $str, $params);
	}
	
		
	public function modelLoad($model, $id){
		$model = NActiveRecord::model($model)->findByPk($id);
		if($model===null)
			throw new CHttpException (404,'no model found');
		return $model;
	}
	
	/**
	 * gets the request data
	 * 
	 * @return array 
	 */
	public function getRESTData(){
		// if the request is formatted as json!
		// Yii::app()->request->getAcceptTypes() // make sure we are dealing with json
		if(Yii::app()->request->getIsPutRequest() || Yii::app()->request->getIsPostRequest()){
			// asumming json passed so
			$data = file_get_contents('php://input');
			return CJSON::decode($data);
		}
	}
	
	
	/**
	 *
	 * @param type $data
	 * @param type $status
	 * @param type $contentType 
	 */
	public function RESTResponse($data, $status = 200, $contentType = 'application/json'){
		// should use the content-type header or the url suffix to determine the output format
		// var_export($data, TRUE);
		// header("Content-Type: $contentType");
		echo CJSON::encode($data);
	}

}