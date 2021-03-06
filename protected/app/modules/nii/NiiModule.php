<?php
Yii::import('nii.models.*');
/**
 * NiiModule class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
class NiiModule extends NWebModule
{
	
	public $name = 'Nii';
	
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
		Yii::import('nii.models.*');
		Yii::import('nii.components.behaviors.*');
		
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
		
		Yii::import('nii.widgets.notes.models.NNote');
		Yii::app()->onAfterModulesSetup = array($this, 'afterSetup');
	}
	
	public function afterSetup(){
		// register the sprite css file
		Yii::app()->sprite->registerSpriteCss();
	}
	
	public function registerScripts(){
		
		$cs = Yii::app()->getClientScript();
		
		Yii::app()->getClientScript()->registerCoreScript('yiiactiveform');
		
		// use packages to manage javascript, could be placed into a packages.php file
		// possible implementation:
		$cs->packages =  array(
			'nii' => array(
				'basePath'=>'nii.assets',
				'baseUrl'=>$this->getAssetsUrl(),
				'js'=>array(
					'js/jquery.metadata.js',
					'js/nii.js',
					'js/functions.js',
				),
				'css'=>array(
					'oocss/all.css',
					'jqueryui/nii/jquery-ui.css',
				),
				'depends'=>array('jquery.ui')
			),
			'backbone'=>array(
				'basePath'=>'nii.assets',
				'baseUrl'=>$this->getAssetsUrl(),
				'js'=>array(
					'js/backbone/underscore-1.3.1.min.js',
					'js/backbone/backbone-0.9.1.min.js',
				),
				'depends'=>array('jquery')
			),
			'fullcalendar'=>array(
				'basePath'=>'nii.assets',
				'baseUrl'=>$this->getAssetsUrl(),
				'css'=>array(
					'js/fullcalendar/fullcalendar.css',
				),
				'js'=>array(
					'js/fullcalendar/fullcalendar.min.js',
				),
				'depends'=>array('jquery')
			)
		);
		Yii::app()->getClientScript()->registerPackage('nii');
		Yii::app()->getClientScript()->registerPackage('backbone');
		
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
					'NTabs' => array(
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
			'backbone-0.9.1.min.js'=>false,
			'underscore-1.3.1.min.js'=>false,
			'jquery.gritter.min.js'=>false,
			'jquery.gritter.css'=>false,
			'jquery.yiiactiveform.js'=>false,
			'bootstrap-min.css'=>false,
			// Prevent gridview styles from loading on ajax
			'styles.css'=>false,
			'bootstrap.min.js'=>false,
			'functions.js'=>false,
			'jquery.ba-bbq.js'=>false,
		);
	}
	
	public function install(){
		Yii::import('nii.widgets.notes.models.NNote');
		Yii::import('nii.models.*');
		Yii::import('nii.components.behaviors.*');
		NLog::install('NLog');
		NNote::install();
		NFile::install();
		NAttachment::install();
		NRelationship::install();
		NSettings::install();
		NTaggable::install();
	}
	
	public function uninstall() {
		Yii::import('nii.components.behaviors.*');
		NTaggable::uninstall();
	}
	
	/**
	 * shortcut method to return the Nii module
	 * @return NiiModule 
	 */
	public static function get(){
		return yii::app()->getModule('nii'); 
	}
	
}