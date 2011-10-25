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
	
	/**
	 * to change the jquery ui theme point this to the theme folder.
	 * if blank defaults to assets folder nii theme
	 * @var string url path to the jquery ui theme folder 
	 */
	public $juiThemeUrl;
	
	/**
	 * jquery ui theme name
	 * defaults to nii.
	 * @var string 
	 */
	public $juiTheme = 'nii';
	
	
	public function init(){
		
		if(Yii::app()->domain){
			// this is important it makes the cache specific to the domain application instance.
			// The cache is shared across the application. Therefore the cache id must be specific to each users application
			// domain instance
			Yii::app()->cache->keyPrefix = Yii::app()->getSubDomain();
			// fix the cahce file path and filemanager path to be specific per domain
			Yii::app()->fileManager->location = Yii::getPathOfAlias('domain.uploads.'.Yii::app()->getSubDomain());
		}
		// register nii js goodness
		$this->registerScripts();
	}
	
	public function registerScripts(){
		
		$cs = Yii::app()->getClientScript();
		
		// register the sprite css file
		Yii::app()->sprite->registerSpriteCss();
		
		
		Yii::app()->getClientScript()->registerCoreScript('yiiactiveform');
		
		
		// use packages to manage javascript, could be placed into a packages.php file
		// possible implementation:
		 $cs->packages =  array(
			'nii' => array(
				'basePath'=>'nii.assets',
				'baseUrl'=>$this->getAssetsUrl(),
				'js'=>array(
					'js/jquery.metadata.js', 
					'js/tipsy/javascripts/jquery.tipsy.js',
					'js/nii.js', 
					'js/jquery.hotkeys.js',
					'js/backbone/underscore-1.1.7.min.js',
					'js/backbone/backbone-0.5.3.min.js',
					'js/gritter/js/jquery.gritter.min.js',
				),
				'css'=>array(
					'oocss/all.css',
					'js/tipsy/stylesheets/tipsy.css',
					'js/gritter/css/jquery.gritter.css',
				),
				'depends'=>array('jquery.ui')
			)
		);
		Yii::app()->getClientScript()->registerPackage('nii');
		
		
		if($this->juiThemeUrl===null){
			$this->juiThemeUrl = $this->getAssetsUrl().'/jqueryui';
		}
		
		Yii::app()->setComponents(array(
			// enables theme based JQueryUI's
			'widgetFactory' => array(
				'widgets' => array(
					'CJuiAutoComplete' => array(
						'themeUrl' => $this->juiThemeUrl,
						'theme' => $this->juiTheme,
					),
					'CJuiDialog' => array(
						'themeUrl' => $this->juiThemeUrl,
						'theme' => $this->juiTheme,
					),
					'CJuiWidget' => array(
						'themeUrl' => $this->juiThemeUrl,
						'theme' => $this->juiTheme,
					),
					'CJuiInputWidget' => array(
						'themeUrl' => $this->juiThemeUrl,
						'theme' => $this->juiTheme,
					),
					'CJuiTabs' => array(
						'themeUrl' => $this->juiThemeUrl,
						'theme' => $this->juiTheme,
					),
					'CJuiWidget' => array(
						'themeUrl' => $this->juiThemeUrl,
						'theme' => $this->juiTheme,
					),
					'CJuiButton' => array(
						'themeUrl' => $this->juiThemeUrl,
						'theme' => $this->juiTheme,
					),
					'CJuiDatePicker' => array(
						'themeUrl' => $this->juiThemeUrl,
						'theme' => $this->juiTheme,
					),
				)
			),
		));
	}
	
	
	/**
	 * return array of the scripts not to include from ajax
	 * note: these will likely mirror the scripts registered on every page load by
	 * NiiModule::registerScripts
	 */
	public function ajaxScriptMap(){
		return array (
			'jquery.js'=>false,
			'jquery.min.js'=>false,
			'jquery-ui.min.js'=>false,
			'jquery-ui.css'=>false,
			'jquery.tipsy.js'=>false,
			'jquery.tipsy.css'=>false,
			'jquery.metadata.js'=>false,
			'tipsy.css'=>false,
			'jquery.hotkeys.js'=>false,
			'nii.js'=>false,
			'all.css'=>false,
			'sprite.css'=>false,
			'backbone-0.5.3.min.js'=>false,
			'underscore-1.1.7.min.js'=>false,
			'jquery.gritter.min.js'=>false,
			'jquery.gritter.css'=>false,
			'jquery.yiiactiveform.js'=>false
		);
	}
	
	
	public function install(){
		Yii::import('nii.widgets.notes.models.NNote');
		Yii::import('nii.models.*');
		NNote::install();
		NFile::install();
		NSettings::install();
	}
	
	/**
	 * shortcut method to return the Nii module
	 * @return NiiModule 
	 */
	public static function get(){
		return yii::app()->getModule('nii'); 
	}
	
}