<?php
Yii::import('nii.models.*');
/**
 * Yii-User module
 * 
 * @author Mikhail Mangushev <mishamx@gmail.com> 
 * @link http://yii-user.googlecode.com/
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @version $Id: UserModule.php 105 2011-02-16 13:05:56Z mishamx $
 */
class NiiModule extends NWebModule
{
	
	
	public function init(){
		// register nii js goodness#
		$this->registerScripts();
		
	}
	
	public function registerScripts(){
		$cs = Yii::app()->getClientScript();
		Yii::app()->getClientScript()->registerCoreScript("jquery.ui");
		$cs->registerScriptFile($this->getAssetsUrl().'/js/jquery.metadata.js');
		$cs->registerScriptFile($this->getAssetsUrl().'/js/tipsy/javascripts/jquery.tipsy.js');
		$cs->registerCssFile($this->getAssetsUrl().'/oocss/all.css');
		$cs->registerCssFile($this->getAssetsUrl().'/js/tipsy/stylesheets/tipsy.css');
		$cs->registerScriptFile($this->getAssetsUrl().'/js/nii.js');
		$cs->registerScriptFile($this->getAssetsUrl().'/js/jquery.hotkeys.js');
	}
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			if(!Yii::app()->getRequest()->getIsAjaxRequest()){
				// register scripts here;
			}
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	/**
	 * return array of the scripts not to include from ajax
	 * note: these will likely mirror the scripts registered on every page load by
	 * NiiModule::registerScripts
	 */
	public function ajaxScriptMap(){
		return array (
			'jquery.js'=>false,
			'jquery-ui.min.js'=>false,
			'jquery-ui.css'=>false,
			'jquery.tipsy.js'=>false,
			'jquery.tipsy.css'=>false,
			'jquery.metadata.js'=>false,
			'nii.js'=>false,
			'all.css'=>false,
			'tipsy.css'=>false,
			'jquery.hotkeys.js'=>false
		);
	}
	
	
	
	
	public function install(){
		Yii::import('nii.widgets.notes.models.NNote');
		NNote::install();
		NFile::install();
	}
	
	/**
	 * shortcut method to return the Nii module
	 * @return NiiModule 
	 */
	public static function get(){
		return yii::app()->getModule('nii'); 
	}
	
}
