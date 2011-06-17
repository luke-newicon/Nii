<?php
/**
 * Yii-User module
 * 
 * @author Mikhail Mangushev <mishamx@gmail.com> 
 * @link http://yii-user.googlecode.com/
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @version $Id: UserModule.php 105 2011-02-16 13:05:56Z mishamx $
 */

class UserModule extends NWebModule
{
	/**
	 * @var int
	 * @desc items on page
	 */
	public $user_page_size = 10;
	
	/**
	 * @var int
	 * @desc items on page
	 */
	public $fields_page_size = 10;
	
	/**
	 * @var boolean
	 * @desc use email for activation user account
	 */
	public $sendActivationMail=true;
	
	/**
	 * @var boolean
	 * @desc allow auth for users that are not active
	 */
	public $loginNotActive=false;
	
	/**
	 * @var boolean
	 * @desc activate user on registration (only $sendActivationMail = false)
	 */
	public $activeAfterRegister=false;
	
	/**
	 * @var boolean
	 * @desc login after registration (need loginNotActiv or activeAfterRegister = true)
	 */
	public $autoLogin=true;
	
	public $registrationUrl = array("/user/account/registration");
	public $recoveryUrl = array("/user/account/recovery");
	public $loginUrl = array("/user/account/login");
	public $logoutUrl = array("/user/account/logout");
	public $profileUrl = array("/user/profile/index");
	public $returnUrl = array("/user/dashboard");
	public $returnLogoutUrl = array("/user/account/login");

	public $userClass = 'User';

	public $fieldsMessage = '';

	
	public $tableUsers = '{{user_user}}';
	public $tableProfiles = '{{crm_contact}}';

	/**
	 * Whether a user must proide a unique username
	 * @var boolean 
	 */
	public $usernameRequired = true;
	
	/**
	 * Whether to show the username input field on user registration
	 * @var boolean 
	 */
	public $showUsernameField = true;
	
	/**
	 * Whether to make the app user module domain specific 
	 * (also adds required domain field to the user signup form)
	 * @var boolean 
	 */
	public $domain = false;
	
	/**
	 * on registration the user must accept terms
	 * to complete, if this is false, the terms option will not appear.
	 * @var type 
	 */
	public $termsRequired = true;

	
	/**
	 * use captcha on registration form
	 * @var boolean
	 */
	public $registrationCaptcha = true;

	/**
	 * This is set to false automatically if the CRM module is not loaded
	 * @var type 
	 */
	public $useCrm = true;
	
	static private $_user;
	static private $_admin;
	static private $_admins;
	
	/**
	 * @var array
	 * @desc Behaviors for models
	 */
	public $componentBehaviors=array();

	public function  preinit() {
		if(Yii::app()->getModule('crm') === null)
			$this->useCrm = false;
		parent::preinit();
	}

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'user.models.*',
			'user.components.*',
		));

		if(!Yii::app()->user->isGuest)
			$this->addMenuItem(CHtml::image(Yii::app()->baseUrl.'/images/user_gray.png', 'Users'), array('/user/index/index'));
		
		// add to the main config
		Yii::app()->components = array(
			'authManager'=>array(
				'class'=>'CDbAuthManager',
				'connectionID'=>'db',
				'assignmentTable'=>'auth_assignment',
				'itemChildTable'=>'auth_item_child',
				'itemTable'=>'auth_item',
				'defaultRoles'=>array('authenticated', 'guest'),
			)
		);
		
	}
	
	public function getBehaviorsFor($componentName){
        if (isset($this->componentBehaviors[$componentName])) {
            return $this->componentBehaviors[$componentName];
        } else {
            return array();
        }
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
	 * @param $str
	 * @param $params
	 * @param $dic
	 * @return string
	 */
	public static function t($str='',$params=array(),$dic='user') {
		return Yii::t("UserModule.".$dic, $str, $params);
	}

	
	/**
	 * @param $place
	 * @return boolean 
	 */
	public static function doCaptcha($place = '') {
		if(!extension_loaded('gd'))
			return false;
		return Yii::app()->getModule('user')->registrationCaptcha;
	}
	
	/**
	 * Return admin status.
	 * @return boolean
	 */
	public static function isAdmin() {
		if(Yii::app()->user->isGuest)
			return false;
		else {
			if (!isset(self::$_admin)) {
				if(self::user()->superuser)
					self::$_admin = true;
				else
					self::$_admin = false;	
			}
			return self::$_admin;
		}
	}

	/**
	 * Return admins. All (superusers)
	 * @return array syperusers names
	 */	
	public static function getAdmins() {
		if (!self::$_admins) {
			$admins = UserModule::userModel()->active()->superuser()->findAll();
			$return_name = array();
			foreach ($admins as $admin)
				array_push($return_name,$admin->username);
			self::$_admins = $return_name;
		}
		return self::$_admins;
	}
	
	/**
	 * Send mail method
	 */
	public static function sendMail($email,$subject,$message) {
    	$adminEmail = Yii::app()->params['adminEmail'];
	    $headers = "MIME-Version: 1.0\r\nFrom: $adminEmail\r\nReply-To: $adminEmail\r\nContent-Type: text/html; charset=utf-8";
	    $message = wordwrap($message, 70);
	    $message = str_replace("\n.", "\n..", $message);
	    return mail($email,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
	}
	
	/**
	 * Return safe user data as a CActiveRecord class of User or defined parent class (defined in UserModule::userClass)
	 * @param user id not required
	 * @return user object or null
	 */
	public static function user($id=0) {
		if ($id) 
			return UserModule::userModel()->active()->findbyPk($id);
		else {
			if(Yii::app()->user->isGuest) {
				return false;
			} else {
				if (!self::$_user)
					self::$_user = UserModule::userModel()->active()->findbyPk(Yii::app()->user->id);
				return self::$_user;
			}
		}
	}

	/**
	 * get the static instance of the user class
	 * equivelent of UserModule::userModel() however it allows one to use a different extended class other than User
	 * This class is defined by userClass property
	 * @return User
	 */
	public static function userModel(){
		$class = Yii::app()->getModule('user')->userClass;
		return NActiveRecord::model($class);
	}

	/**
	 *
	 * @return UserModule
	 */
	public static function get(){
		return Yii::app()->getModule('user');
	}
	
	
	/**
	 * EVENTS ... events ROCK!
	 */
	
	
	/**
	 * When a user finishes successfull registration.
	 * This is when registration form has been successfully completed
	 * and the user added to the database
	 * @param CEvent $event contains a user parameter with the user active record
	 * object in it.
	 */
	public function onRegistrationComplete($event){
		$this->raiseEvent('onRegistrationComplete', $event);
	}
	
	
	/**
	 *
	 * @param type $event 
	 */
	public function onActivation($event){
		$this->raiseEvent('onActivation', $event);
	}
	
	
	public function install(){
		AuthItem::install();
		AuthAssignment::install();
		AuthItemChild::install();
		User::install();
		if($this->domain){
			AppDomain::install();
			AppUserDomain::install();
		}
		//$this->runMySql();
	}
	
}
