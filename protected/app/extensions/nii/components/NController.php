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
			Yii::app()->clientScript->scriptMap=array('jquery.js'=>false);
		} else {
			// include my scripts!
			$path = Yii::getPathOfAlias('application.extensions.scripts');
			$this->coreAssets = Yii::app()->getAssetManager()->publish($path);
			Yii::app()->getClientScript()->registerScriptFile($this->coreAssets.'/jquery/jquery.scrollto.js');
			Yii::app()->getClientScript()->registerCoreScript("jquery");
			Yii::app()->getClientScript()->registerCoreScript("jquery.ui");
			Yii::app()->getClientScript()->registerCoreScript("ajaxqueue");
		}
	}

	
	public function filters()
    {
        return array(
            'accessControl',
        );
    }
	
}