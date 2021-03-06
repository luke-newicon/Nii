<?php

class AccountController extends NController {
	
	/**
	 * @var string the default layout for the controller view.
	 */
	public $layout = '//layouts/login';

	public function accessRules() {
		return array(
			array('allow',
				'actions' => array('login', 'logout', 'registration','activation', 'recovery', 'captcha'),
				'users' => array('*')
			),
			array('deny',
				'actions'=> array('index'),
				'users' => array('?')
			)
		);
	}

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return (isset($_POST['ajax']) && $_POST['ajax']==='registration-form')?array():array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	
	
	/**
	 * Development
	 * TODO: create a record to represent the new user.
	 * Access email and other basic user information from google and match that to our user record.  
	 * Also need to store the google token in the user record.
	 */
	public function actionLoginGoogle() {
 
        Yii::import('user.components.oauth.*');
		Yii::import('user.components.oauth.lib.*');
 
        $ui = new EOAuthUserIdentity(
                array(
                    //Set the "scope" to the service you want to use
                        'scope'=>'https://sandbox.google.com/apis/ads/publisher/',
                        'provider'=>array(
                                'request'=>'https://www.google.com/accounts/OAuthGetRequestToken',
                                'authorize'=>'https://www.google.com/accounts/OAuthAuthorizeToken',
                                'access'=>'https://www.google.com/accounts/OAuthGetAccessToken',
                        )
                )
        );
 
        if ($ui->authenticate()) {
            $user=Yii::app()->user;
            $user->login($ui);
            $this->redirect($user->getReturnUrl());
        }
        else throw new CHttpException(401, $ui->error);
 
    }
	

	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		if (Yii::app()->user->isGuest) {
			$userLogin = new UserLogin;
			$this->performAjaxValidation($userLogin, 'login-user-form');
			// collect user input data
			if (isset($_POST['UserLogin'])) {
				$userLogin->attributes = $_POST['UserLogin'];
				// validate that the username and password are valid
				if ($userLogin->login()) {
					$this->redirect(Yii::app()->user->returnUrl);
				}else{
					// check domain
					if($userLogin->isValidButWrongDomain()){
						$this->transferToDomain($userLogin->getUserIdentity());
					}
				}
			}
			// display the login form
			$this->render('login', array('model' => $userLogin));
		} else {
			$this->redirect(Yii::app()->user->returnUrl);
		}
	}
	
	/**
	 * action to manage your own account (user must be logged in)
	 */
	public function actionIndex(){
		$this->render('index',array('model'=>Yii::app()->user->record));
	}
	
	/**
	 * This function handles the scenario where a user is logging in from the wrong domain.
	 * It redirects the browser to the correct domain for the user and reposts the login form.
	 * @param UserLogin $userLogin 
	 */
	public function transferToDomain($userIdentity){
		
		if (UserModule::get()->domain) {
			// if the user is trying to log into the wrong subdomain but is a valid user
			if ($userIdentity!==null && $userIdentity->errorCode == UserIdentity::ERROR_DOMAIN) {
				// unbelievable that it comes to this...
				// but even the paypal IPN modules in magento and zen cart use this method
				// To post data to a redirect page
				if($userIdentity->getUser()->domain==''){
					$url = NHtml::url('/user/account/login');
				}else{
					$schema = (Yii::app()->https) ? 'https://' : 'http://';
					$url = $schema . $userIdentity->getUser()->domain.'.'.Yii::app()->hostname . NHtml::url('/user/account/login');
				}
				echo $this->render('transfer',array('userIdentity'=>$userIdentity, 'action'=>$url),true);
				exit();
			}
		}
	}
	

	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->getModule('user')->returnLogoutUrl);
	}


	/**
	 * Registration user
	 */
	public function actionRegistration() {

		$userModule = UserModule::get();
		// array of models to validate
		$models = array();
		
		$user = new RegistrationForm;
		$domain = null;
		
		// populate array of models to validate
		$models[] = $user;

		if($userModule->domain) {
			$domain = new AppDomain;
			$models[] = $domain;
		}
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
		{	
			echo CActiveForm::validate($models);
			Yii::app()->end();
		}

		if (Yii::app()->user->id) {
			$this->redirect($userModule->returnUrl);
		} else {
			if(isset($_POST['RegistrationForm'])) {
				// validate all models enabled
				// i want validate to be called on all models 
				// but if any one is false i want valid to be false
				$valid = array();
				foreach($models as $model){
					$model->attributes=$_POST[get_class($model)];
					$valid[] = $model->validate();
				}
				// if any of the models failed validation
				if(!in_array(false, $valid))
				{
					$user->createtime=time();
					$user->superuser=0;
					$user->status=(($userModule->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
					// prossess domain
					if($userModule->domain){
						$domain->save();
						$user->domain = $domain->domain;
					}
					
					$user->trial = 1;
					$user->trial_ends_at = date('Y-m-d',mktime(0,0,0,date("m"),date("d") +30, date("Y")));
					
					$user->save();

					if ($userModule->sendActivationMail) {
						$activationUrl = $this->makeActivationLink($user, '/user/account/activation');
						UserModule::sendMail($user->email,
							UserModule::t("You registered from {site_name}",
								array('{site_name}'=>Yii::app()->name)),
							UserModule::t("Please activate you account go to {activation_url}",
								array('{activation_url}'=>$activationUrl)));
					}

					// if users can login imediately after registration
					if (($userModule->loginNotActive ||($userModule->activeAfterRegister)) && $userModule->autoLogin) {
						$username = ($user->username=='')?$user->email:$user->username;
						$identity=new UserIdentity($username,$_POST['RegistrationForm']['password']);
						$identity->authenticate();
						
						// call external events!
						$e = new CEvent($this, array('user'=>$user));
						$userModule->onRegistrationComplete($e);
				
						$this->transferToDomain($identity);

						$this->redirect($userModule->returnUrl);
						
					} else {
						if (!$userModule->activeAfterRegister && !$userModule->sendActivationMail) {
							Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
						} elseif($userModule->activeAfterRegister && $userModule->sendActivationMail==false) {
							Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please {{login}}.", array('{{login}}'=>CHtml::link(UserModule::t('Login'),$userModule->loginUrl))));
						} elseif($userModule->loginNotActive) {
							Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email or login."));
						} else {
							Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email."));
						}
					}
					// call external events!
					$e = new CEvent($this, array('user'=>$user));
					$userModule->onRegistrationComplete($e);
				}
			}
			$this->render('registration',array('model'=>$user,'domain'=>$domain));
		}
	}
	

	/**
	 * Activattion link for user account
	 */
	public function actionActivation() {
		$email = NData::base64UrlDecode($_GET['e']);
		$activekey = $_GET['activekey'];
		if ($email&&$activekey) {
			$user = UserModule::userModel()->notsafe()->findByAttributes(array('email'=>$email));
			if(isset($user) && $user->email_verified == 0 && $user->status == 1){
				// user is active but has not verified his email
				$user->email_verified = 1;
				$user->save();
				$this->render('message',array('title'=>UserModule::t("Email Verfied"),'content'=>UserModule::t("Thank you! We now know you are you!")));
			} elseif (isset($user) && $user->status==1 && $user->email_verified==1) {
			    $this->render('message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("Your account is active.")));
			} elseif(isset($user->activekey) && $this->checkActivationKey($user, $activekey)) {
				$user->activekey = crypt(microtime());
				$user->status = 1;
				$user->email_verified = 1;
				$user->save();
			    $this->render('activation');
				$e = new CEvent($this, array('user'=>$user));
				UserModule::get()->onActivation($e);
			} else {
			    $this->render('message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("Incorrect activation URL.")));
			}
		} else {
			$this->render('message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("Incorrect activation URL.")));
		}
	}


	/**
	 * returns the encoded activation key
	 * @param User $u
	 * @return type
	 */
	public function makeActivationLink(User $u, $url)
	{
		return $this->createAbsoluteUrl($url,array(
			"activekey" =>$this->makeKeyPretty($u->activekey),
			"e" => NData::base64UrlEncode($u->email)
		));
	}


	/**
	 * Check the activation key to ensure the authentisity of this activation
	 * request
	 * @param User $u the user to which the key should match
	 * @param string $urlKey the key recieved by the controller
	 * @return boolean true the key matches the user and is authorised.
	 */
	public function checkActivationKey(User $u, $urlKey)
	{
		// need to perform the same processing to the users key as the $urlKey
		// recieved before it was sent
		return (NData::base64UrlDecode($this->makeKeyPretty($u->activekey))==NData::base64UrlDecode($urlKey));
	}

	/**
	 * Dont want the activation key url variable to be a huge link
	 * So lets only send over a few select characters from the key
	 * @return type
	 */
	public function makeKeyPretty($activeKey)
	{
		$ak = NData::base64UrlEncode($activeKey);
		$compareKeyChars = array(1,5,2,7,3,9,11);
		$key = '';
		foreach($compareKeyChars as $index)
			$key .= substr ($ak, $index, 1);
		return $key;
	}


	/**
	 * Recovery password
	 */
	public function actionRecovery () {
		$form = new UserRecoveryForm;
		if (Yii::app()->user->id) {
			$this->redirect(Yii::app()->user->getReturnUrl());
		} else {
			$email = NData::base64UrlDecode(((isset($_GET['e']))?$_GET['e']:''));
			$activekey = ((isset($_GET['activekey']))?$_GET['activekey']:'');
			if ($email&&$activekey) {
				$form2 = new UserPasswordForm;
				$find = UserModule::userModel()->notsafe()->findByAttributes(array('email'=>$email));
				if (isset($find) && $this->checkActivationKey($find, $activekey)) {
					if(isset($_POST['UserPasswordForm'])) {
						$form2->attributes=$_POST['UserPasswordForm'];
						if($form2->validate()) {
							// if account is not active make it active
							if ($find->status==0) {
                                $find->status = 1;
							}
							$find->password = UserModule::passwordCrypt($form2->password);
							$find->save();
							Yii::app()->user->setFlash('success',UserModule::t("A new password has been saved. You can now log in using your new password."));
							$this->redirect(Yii::app()->controller->module->loginUrl);
						}
					}
					$this->render('changepassword',array('model'=>$form2));
				} else {
					Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Incorrect recovery link."));
					$this->redirect(Yii::app()->controller->module->recoveryUrl);
				}
			} else {
				if(isset($_POST['UserRecoveryForm'])) {
					$form->attributes=$_POST['UserRecoveryForm'];
					if($form->validate()) {
						$user = UserModule::userModel()->notsafe()->findbyPk($form->user_id);
						$activation_url = $this->makeActivationLink($user, '/user/account/recovery');

						$subject = UserModule::t("You have requested password recovery from {site_name}",array('{site_name}'=>Yii::app()->name));
						$message = UserModule::t("You have requested password recovery from {site_name}. To receive a new password, go to {activation_url}.",array('{site_name}'=>Yii::app()->name, '{activation_url}'=>$activation_url));
						UserModule::sendMail($user->email,$subject,$message);

						Yii::app()->user->setFlash('recoveryMessage',UserModule::t("Instructions on how to reset your password have been sent to your registered email address."));
						$this->refresh();
					}
				}
				$this->render('recovery',array('model'=>$form));
			}
		}
	}
	
	public function actionChangepassword(){
		$model = new UserPasswordForm;
		$this->render('changepassword',array('model'=>$model));
	}
}
