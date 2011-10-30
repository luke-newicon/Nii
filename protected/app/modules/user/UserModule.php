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

	public $name = 'Users';
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
	 * @desc activate user on registration (required $sendActivationMail = false)
	 */
	public $activeAfterRegister=false;
	
	/**
	 * @var boolean
	 * @desc login after registration (requires loginNotActive or activeAfterRegister = true)
	 */
	public $autoLogin=true;
	
	/**
	 * how long the cookie should last that identifies the user
	 * @var int (number of seconds) 
	 */
	public $rememberMeDuration = 2592000; // 30 days = (3600*24*30)
	
	
	/**
	 * The route to the user registration page
	 * @var mixed route
	 */
	public $registrationUrl = array("/user/account/registration");
	
	/**
	 * The route to the recovery page (allows you to recover your password)
	 * @var mixed route
	 */
	public $recoveryUrl = array("/user/account/recovery");
	
	/**
	 * the route to the login page
	 * @var mixed route
	 */
	public $loginUrl = array("/user/account/login");
	
	/**
	 * the url to go to once a user successfully logs in.
	 * @var mixed route
	 */
	public $logoutUrl = array("/user/account/logout");
	
	/**
	 * where to go on successful login
	 * @var mixed route 
	 */
	public $returnUrl = array("/user/dashboard");
	/**
	 * the page to go to after logout
	 * @var mixed route 
	 */
	public $returnLogoutUrl = array("/user/account/login");

	/**
	 * The class name of the User model
	 * This is a last resort it is better to use behaviours to add functionality
	 * @var string 
	 */
	public $userClass = 'User';


	/**
	 * The database tablename for the user model
	 * @var string 
	 */
	public $tableUsers = '{{user_user}}';

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
	 * This will be automatically set by nii's domain property
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


	
	static private $_user;
	static private $_admin;
	static private $_admins;
	
	/**
	 * @var array
	 * @desc Behaviors for models
	 */
	public $componentBehaviors=array();


	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// remember Yii app should be pointing to Nii!
		$this->domain = Yii::app()->domain;
		// import the module-level models and components
		$this->setImport(array(
			'user.models.*',
			'user.components.*',
		));
		
		Yii::app()->getModule('admin')->menu->addMenu('user');
		
		Yii::app()->getModule('admin')->menu->addItem('user','User',array('/user/admin'));
		Yii::app()->getModule('admin')->menu->addItem('user','Account',array('/user/admin/account'),'User',array('linkOptions'=>array('data-controls-modal'=>'modal-user-account','data-backdrop'=>'static')));
		Yii::app()->getModule('admin')->menu->addItem('user','Settings',array('/user/admin/settings'),'User');
		
		Yii::app()->getModule('admin')->menu->addItem('secondary','Users',array('/user/admin/users'),'Admin');
		Yii::app()->getModule('admin')->menu->addItem('secondary','Permissions',array('/user/admin/roles'),'Admin');

		
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
	
	public function permissions() {
		return array(
			'user' => array('label' => 'Users', 'roles' => array('admin','edit','view'), 'items' => array(
				'user/admin/index' => array('label' => 'User main page', 'roles' => array('admin','edit','view')),
				'user/admin/settings' => array('label' => 'User settings', 'roles' => array('admin','edit','view')),
				'user/admin/users' => array('label' => 'User management', 'roles' => array('admin')),
				'user/admin/roles' => array('label' => 'Role management', 'roles' => array('admin')),
				'user/admin/addUser' => array('label' => 'Add a user', 'roles' => array('admin')),
				'user/admin/editUser' => array('label' => 'Edit a user', 'roles' => array('admin')),
				'user/admin/delete' => array('label' => 'Delete a user', 'roles' => array('admin')),
				'user/admin/account' => array('label' => 'User account', 'roles' => array('admin','edit','view')),
				'user/admin/changePassword' => array('label' => 'Change password', 'roles' => array('admin','edit','view')),
				'user/admin/impersonate' => array('label' => 'Impersonate a user', 'roles' => array('admin')),
			)),
		);
	}
	
	public function getBehaviorsFor($componentName){
        if (isset($this->componentBehaviors[$componentName])) {
            return $this->componentBehaviors[$componentName];
        } else {
            return array();
        }
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
	    mail($email,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
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
	 * check the password is correct
	 * @param string $dbPass the initial password stored in the database
	 * @param type $checkPass the password to check against
	 * @return boolean 
	 */
	public static function checkPassword($dbPass,$checkPass) {
		//$salt = substr($dbPass, 0, CRYPT_SALT_LENGTH);
		return ($dbPass == crypt($checkPass, $dbPass));
	}
	
	/**
	 *
	 * @param type $password
	 * @return type function used to crypt the password.
	 */
	public static function passwordCrypt($password){
		return crypt($password);
	}
	
	
	/**
	 * EVENTS ... events ROCK!
	 */
	
	
	/**
	 * When a user finishes successfull registration.
	 * This is when registration form has been successfully completed
	 * and the user added to the database
	 * @param CEvent $event contains the following properties:
	 *  - CEvent $user = the user active record object.
	 *  - CEvent $plan = a string identifying a plan passed to the registration form
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
	
	
	/**
	 * user module installation
	 * @return void
	 */
	public function install(){
		// Install the auth tables
		AuthItem::install();
		AuthAssignment::install();
		AuthItemChild::install();
		// Create the default roles
		if(!Yii::app()->authManager->getAuthItem('admin'))
			Yii::app()->authManager->createRole('admin','Administrator');
		if(!Yii::app()->authManager->getAuthItem('edit'))
			Yii::app()->authManager->createRole('edit','Editor');
		if(!Yii::app()->authManager->getAuthItem('view'))
			Yii::app()->authManager->createRole('view','Viewer');
		// Install the user table
		User::install();
		// If there is an app domain install it
		if($this->domain){
			AppDomain::install();
		}
	}
	
}
