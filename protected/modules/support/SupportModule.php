<?php
/**
 * SupportModule class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://www.newicon.org/
 * @copyright Copyright &copy; 20010-2011 Newicon Ltd
 * @license http://www.newicon.org/license/
 */

/**
 * SupportModule is the module class for the support system
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @version $Id: SupportModule.php $
 * @package Support
 */
class SupportModule extends NWebModule
{
	
	/**
	 * @label Email Address
	 * @guideText The support email address that messages will be sent from e.g. support@newicon.net
	 * @property string
	 */
	public $email = 'steve@newicon.net';
	
	/**
	 * support email name i.e newicon support team
	 * @property string
	 */
	public $emailName = 'Newicon Support';
	
	/**
	 * the host server name e.g. snarf.cm.bytemark.co.uk
	 * @property string
	 */
	public $emailHost = 'imap.gmail.com';
	/**
	 * imap/pop mailbox username
	 * @property string
	 */
	public $emailUsername = 'steve@newicon.net';
	/**
	 * imap/pop mailbox password
	 * @property string
	 */
	public $emailPassword = 'mushroom11';
	
	/**
	 * imap/pop port
	 * @property string
	 */
	public $emailPort=993;
	
	/**
	 * "SSL" or "TLS"
	 * @property string
	 */
	public $emailSsl='SSL';
	
	/**
	 * folder default 'inbox'
	 * @property string
	 */
	public $folder;

	/**
	 *
	 * @property string
	 */
	public $autoReply;

	/**
	 * autoCron specifies wheather the framework should call cron jobs on page 
	 * loading, this option should be set to false if a cron job has been set to 
	 * run periodically.
	 * @property boolean
	 */
	public $autoCron = false;
	
	/**
	 * The text to prepend the subject ticket id with
	 * @property string 
	 */
	public $subjectPrepend = '#';

	/**
	 * The number of messages to load per page
	 * @var int
	 */
	public $msgPageLimit = 30;
	
	/**
	 * whether to display messages in conversation threads.
	 * @var boolean
	 */
	public $threading = false;
	
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'support.models.*',
			'support.components.*',
		));
		
		$url = Yii::app()->assetManager->publish(Yii::getPathOfAlias('support.assets'));
		if(!Yii::app()->getRequest()->getIsAjaxRequest()){
			Yii::app()->clientScript->registerCssFile("$url/support.css");
			Yii::app()->clientScript->registerCssFile("$url/jquery.jscrollpane.css");
			Yii::app()->clientScript->registerScriptFile("$url/js/jquery.jscrollpane.min.js");
			Yii::app()->clientScript->registerScriptFile("$url/js/jquery.mousewheel.js");
			Yii::app()->clientScript->registerScriptFile("$url/js/jquery.mwheelIntent.js");
		}
		require_once 'Zend/Loader/Autoloader.php';
		Yii::registerAutoloader(array('Zend_Loader_Autoloader', 'autoload'));
		if(!Yii::app()->user->isGuest)
			$this->addMenuItem(CHtml::image(Yii::app()->baseUrl.'/images/email.png', 'Support'), array('/support/index/index'));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

	/**
	 * @return SupportModule
	 */
	public static function get(){
		return Yii::app()->getModule('support');
	}
	
	public function install(){
		
	}
	
	public function getLoadMessageListUrl(){
		if(self::get()->threading)
			echo NHtml::url('/support/index/loadMessageListThreaded/offset');
		else
			echo NHtml::url('/support/index/loadMessageList/offset');
	}
	
	public function getLoadMessageUrl(){
		if(self::get()->threading)
			echo NHtml::url('/support/index/messageThread');
		else
			echo NHtml::url('/support/index/message');
	}
	
	
}