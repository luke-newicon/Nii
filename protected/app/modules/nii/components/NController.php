<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class NController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	
	public $coreAssets;
	
	public function  __construct($id, $module = null) {
		// this method is called before any module controller action is performed
		// you may place customized code here
		
		parent::__construct($id, $module);
		if(Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->layout = '//layouts/ajax.php';
			// prevent jquery being added via ajax as this breaks jquery ui components that ajax in content.
			// specifically dialog boxes! Should also add scripts that are always included
			// remove scripts added every page load by nii.
			// we don't therefore need them to load in on ajax requests!
			Yii::app()->clientScript->scriptMap=NiiModule::get()->ajaxScriptMap();
		} else {
			// include my scripts!
			$this->coreAssets = Yii::app()->getModule('nii')->getAssetsUrl();
			
			Yii::app()->getClientScript()->registerCssFile($this->coreAssets."/jqueryui/nii/jquery-ui.css");

			Yii::app()->getClientScript()->registerScriptFile($this->coreAssets.'/js/jquery.scrollto.js');
			Yii::app()->getClientScript()->registerCoreScript("jquery.ui");
		}

	}

	
	public function filters()
    {
        return array(
            'accessControl',
        );
    }

	public function performAjaxValidation($models, $formName){
		if (isset($_POST['ajax']) && $_POST['ajax'] === $formName) {
			echo CActiveForm::validate($models);
			Yii::app()->end();
		}
	}
	
	
	
	
	
	/**
	 * This function enables the url to contain dashes instead of camel cased action names
	 * @see actions
	 */
	public function createAction($actionID)
	{
		if(($action=parent::createAction($actionID))===null && strpos($actionID, '-') !== false){
			require_once Yii::getPathOfAlias('app.vendors.Zend.Filter').'.php';
			$newActionID = Zend_Filter::filterStatic($actionID, 'Word_DashToCamelCase');
			if(method_exists($this,'action'. $newActionID)){
				return new CInlineAction($this,$newActionID);
			}
		}else{
			return $action;
		}
	}
	
}