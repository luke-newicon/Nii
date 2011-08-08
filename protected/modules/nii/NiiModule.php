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
		$cs->registerScriptFile($this->getAssetsUrl().'/js/nii.js');
		$cs->registerScriptFile($this->getAssetsUrl().'/js/jquery.hotkeys.js');
		
		Yii::app()->sprite->registerSpriteCss();// register the sprite css file
		$cs->registerCssFile($this->getAssetsUrl().'/oocss/all.css');
		$cs->registerCssFile($this->getAssetsUrl().'/js/tipsy/stylesheets/tipsy.css');
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
			'tipsy.css'=>false,
			'jquery.hotkeys.js'=>false,
			'nii.js'=>false,
			'all.css'=>false,
			'sprite.css'=>false
		);
	}
	
	
	
	
	public function install(){
		Yii::import('nii.widgets.notes.models.NNote');
		Yii::import('nii.models.*');
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
