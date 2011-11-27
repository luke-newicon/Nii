<?php

/**
 * ProjecyModule class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of ProjecyModule
 *
 * @author steve
 */
class HotspotModule extends NWebModule
{
	
	public $name = 'Hotspot';

	public function init(){
	
		
		
		$this->setImport(array(
			'hotspot.models.*',
			'hotspot.components.*',
		));
		
		// relies on the image component NImage
		Yii::app()->image->addType('projectThumb',array(
			'resize' => array('width'=>198, 'height'=>158, 'master'=>'width', 'scale'=>'down'),
			'crop'  => array('width'=>198, 'height'=>158, 'left'=>'center', 'top'=>'top'),
			'noimage'=>Yii::getPathOfAlias('hotspot.assets.add-screens').'.png'
		));
		
		Yii::app()->image->addType('projectSidebarThumb',array(
			'resize' => array('width'=>300, 'height'=>400, 'master'=>'width', 'scale'=>'down'),
			// 'crop'  => array('width'=>198, 'height'=>158, 'left'=>'center', 'top'=>'top'),
			// 'noimage'=>Yii::getPathOfAlias('project.assets.add-screens').'.png'
		));
		
		$cs = Yii::app()->getClientScript();
		$url = Yii::app()->getModule('nii')->getAssetsUrl();
		$cs->registerScriptFile("$url/js/backbone/underscore-1.1.7.min.js");
		$cs->registerScriptFile("$url/js/backbone/backbone-0.5.3.min.js");
		
		
		// register an event to be called on user registration so that a welcome email is sent
		UserModule::get()->onRegistrationComplete = array($this, 'registrationComplete');
		
	}
	
	public function setup() {
		Yii::app()->sprite->addImageFolderPath(Yii::getPathOfAlias('hotspot.images'));
	}
	
	/**
	 * Function handling the registrationComplete user event.
	 * Used to send the welcome to hotspot email!
	 */
	public function registrationComplete($event){
		$user =  $event->params['user'];
		// TODO: send email welcome message
		//Yii::app()->email->send('hotspot-welcome', $user->email, array('email'=>$user->email, 'domain'=>$user->domain));
	}
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			if(!Yii::app()->getRequest()->getIsAjaxRequest()){
				Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl().'/jquery.flip.min.js');
				Yii::app()->clientScript->registerCssFile($this->getAssetsUrl().'/hotspot.css');
			}
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	public function install(){
		if(Yii::app()->getModule('hotspot') === null)
			throw new CException('Hotspot requires the "Hotspot Account" module. To be active before installation');
		HotspotProject::install();
		HotspotScreen::install();
		HotspotHotspot::install();
		HotspotTemplate::install();
		HotspotScreenTemplate::install();
		HotspotComment::install();
		HotspotLink::install();
	}
	
	public function uninstall(){
		NActiveRecord::uninstall('HotspotProject');
		NActiveRecord::uninstall('HotspotScreen');
		NActiveRecord::uninstall('HotspotHotspot');
		NActiveRecord::uninstall('HotspotTemplate');
		NActiveRecord::uninstall('HotspotScreenTemplate');
		NActiveRecord::uninstall('HotspotComment');
		NActiveRecord::uninstall('HotspotLink');
	}
	
	/**
	 *
	 * @return HotspotModule
	 */
	public static function get(){
		return Yii::app()->getModule('hotspot');
	}
	
	
	/**
	 * return the total number of screens accross all projects
	 * @return int
	 */
	public static function totalScreens(){
		return ProjectScreen::model()->count();
	}
	
	/**
	 * return the total number of hotspot accross all projects
	 * @return int
	 */
	public static function totalHotspots(){
		// a bit inefficient maybe?
		Yii::beginProfile('calculate total hotspots');
		$templateCount = array();
		foreach(ProjectTemplate::model()->findAll() as $t){
			$templateCount[$t->id] = HotspotHotspot::model()->countByAttributes(array('template_id'=>$t->id));
		}
		$totalTemplateSpots = 0;
		foreach(ProjectScreenTemplate::model()->findAll() as $st){
			if(array_key_exists($st->template_id, $templateCount))
				$totalTemplateSpots += $templateCount[$st->template_id];
		}
		$normHotspots = HotspotHotspot::model()->countByAttributes(array('template_id'=>0));
		Yii::endProfile('calculate total hotspots');
		return $normHotspots + $totalTemplateSpots;
		
	}
	
	/**
	 * return the total number of projects
	 * @return int
	 */
	public static function totalProjects(){
		return HotspotProject::model()->count();
	}
	
	
	/**
	 * return the total number of comments
	 * @return int
	 */
	public static function totalComments(){
		return 50;
	}
	
}