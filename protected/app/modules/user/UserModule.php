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
	
	public $enableGoogleAuth = false;
	

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
			'user.components.oauth.*',
			'user.components.oauth.lib.*',
		));
		
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
		
		// attach event to handle the event after someone logs in.
		$this->onAfterLogin = array($this, 'afterLoginHandler');
	}
	
	public function setup(){
//		if(Yii::app()->user->record && Yii::app()->user->record->update_password){
//			Yii::app()->catchAllRequest = array('/user/account/changepassword');
//		}
	}
	
	public function getImpersonatingUser(){
		if(isset(Yii::app()->session['impersonate_restore']) && Yii::app()->session['impersonate_restore'])
			return $restoreUser = User::model()->findByPk(Yii::app()->session['impersonate_restore']);
		return false;
	}
	
	public function permissions() {
		return array(
			'user' => array('description' => 'Users',
				'tasks' => array(
					'view' => array('description' => 'View Users',
						'roles' => array('administrator'),
						'operations' => array(
							'user/admin/index',
							'user/admin/users',
							'menu-admin',
							'/user/audit/index/',
						),
					),
					'manage' => array('description' => 'Add/Edit/Delete Users',
						'roles' => array('administrator'),
						'operations' => array(
							'user/admin/addUser',
							'user/admin/editUser',
							'user/admin/deleteUser',
							'user/admin/changePassword',
						),
					),
					'permissions' => array('description' => 'Manage Permissions',
						'roles' => array('administrator'),
						'operations' => array(
							'user/admin/permissions',
							'user/admin/permission',
							'user/admin/updatePermission',
							'user/admin/addRole',
							'menu-admin',
						),
					),
					'impersonate' => array('description' => 'Impersonate a User',
						'roles' => array('administrator'),
						'operations' => array(
							'user/admin/impersonate',
						),
					),
				),
			),
			'grid' => array('description' => 'Grid',
				'tasks' => array(
					'grid_actions' => array('description' => 'Generic Grid Actions',
						'roles' => array('administrator', 'editor', 'viewer'),
						'operations' => array(
							'nii/grid/gridSettingsDialog',
							'nii/grid/updateGridSettings',
							'nii/grid/exportDialog',
							'nii/grid/customScopeDialog',
							'nii/grid/updateCustomScope',
							'nii/grid/ajaxUpdateCustomScopeValueBlock',
							'nii/grid/ajaxNewCustomScope',
							'nii/grid/deleteCustomScope',
							'nii/grid/exportDialog',
							'nii/grid/exportProcess',
							'nii/grid/exportDownload',
							'nii/export/dialog',
							'nii/export/process',
							'nii/export/download',
						),
					),
					'grid_actions_bulk' => array('description' => 'Admin Grid Actions',
						'roles' => array('administrator', 'editor'),
						'operations' => array(
							'nii/grid/bulkAction',
						),
					),
				),
			),
		);
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
	
	public function onAfterLogin($event){
		$this->raiseEvent('onAfterLogin', $event);
	}
	
	/**
	 * Handles after login event and records the last visit time and increments the login number
	 * TODO: update audit log to record login time, user and ip address.
	 */
	public function afterLoginHandler($event){
		$u = Yii::app()->user->record;
		$u->lastvisit = date('Y-m-d H:i:s');
		// record the number of times the user has logged in;
		$u->logins += 1;
		$u->save();
		NLog::insertLog('User '.Yii::app()->user->name.' logged in from IP: '.Yii::app()->request->getUserHostAddress());
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
		if(!Yii::app()->authManager->getAuthItem('role-administrator'))
			Yii::app()->authManager->createRole('role-administrator', 'Administrator');
		if(!Yii::app()->authManager->getAuthItem('role-editor'))
			Yii::app()->authManager->createRole('role-editor', 'Editor');
		if(!Yii::app()->authManager->getAuthItem('role-viewer'))
			Yii::app()->authManager->createRole('role-viewer', 'Viewer');
		// Install the default permissions
		$this->installPermissions();
		// Install the user table
		User::install();
		// If there is an app domain install it
		if($this->domain){
			AppDomain::install();
		}
	}
	
}
