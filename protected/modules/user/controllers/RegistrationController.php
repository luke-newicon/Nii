<?php

class RegistrationController extends NController
{
	public $defaultAction = 'registration';
	


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
	 * Registration user
	 */
	public function actionRegistration() {
		$model = new RegistrationForm;
		$contact = new CrmContact;
		$module = $this->getModule();
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
		{
			echo CActiveForm::validate(array($model,$contact));
			Yii::app()->end();
		}

		if (Yii::app()->user->id) {
			$this->redirect($module->profileUrl);
		} else {
			if(isset($_POST['RegistrationForm'])) {
				$model->attributes=$_POST['RegistrationForm'];
				if($model->validate())
				{
					$model->createtime=time();
					$model->superuser=0;
					$model->status=(($module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
					$contact->attributes = $_POST['CrmContact'];
					$contact->type = CrmContact::TYPE_USER;
					$contact->save();
					
					$model->contact_id = $contact->id;
					$model->save();
					if ($module->sendActivationMail) {
						$activationUrl = $this->makeActivationLink($model);
						UserModule::sendMail($model->email,
							UserModule::t("You registered from {site_name}",
								array('{site_name}'=>Yii::app()->name)),
							UserModule::t("Please activate you account go to {activation_url}",
								array('{activation_url}'=>$activationUrl)));
					}

					if (($module->loginNotActive ||($module->activeAfterRegister && $module->sendActivationMail==false))
						&&$module->autoLogin) {
						$identity=new UserIdentity($model->username,$soucePassword);
						$identity->authenticate();
						Yii::app()->user->login($identity,0);
						$this->redirect($module->returnUrl);
					} else {
						if (!$module->activeAfterRegister && !$module->sendActivationMail) {
							Yii::app()->user->setFlash('registration',
								UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
						} elseif($module->activeAfterRegister && $module->sendActivationMail==false) {
							Yii::app()->user->setFlash('registration',
								UserModule::t("Thank you for your registration. Please {{login}}.",
									array('{{login}}'=>CHtml::link(UserModule::t('Login'),$module->loginUrl))));
						} elseif($module->loginNotActive) {
							Yii::app()->user->setFlash('registration',
								UserModule::t("Thank you for your registration. Please check your email or login."));
						} else {
							Yii::app()->user->setFlash('registration',
								UserModule::t("Thank you for your registration. Please check your email."));
						}
						$this->refresh();
					}
				}
			}
			$this->render('/user/registration',array('model'=>$model,'contact'=>$contact));
		}		
	}
	
	
	/**
	 * Activattion link for user account
	 */
	public function actionActivation() {
		$email = NData::base64UrlDecode($_GET['e']);
		$activekey = $_GET['activekey'];
		if ($email&&$activekey) {
			$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
			if (isset($find) && $find->status==1) {
				echo $email;
				echo $find->status;
				echo 'NOT THIS ONE!';
			    $this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("You account is active.")));
			} elseif(isset($find->activekey) && $this->checkActivationKey ($find, $activekey)) {
				echo 'doing this';
				$find->activekey = crypt(microtime());
				$find->status = 1;
				$find->save();
			    $this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("You account is activated.")));
			} else {
			    $this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("Incorrect activation URL.")));
			}
		} else {
			$this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("Incorrect activation URL.")));
		}
	}
	
	public function actionTest(){
		$u = User::model()->notsafe()->findByPk(4);
		echo $this->makeActivationLink($u);
	}
	
	/**
	 * returns the encoded activation key 
	 * @param User $u
	 * @return type 
	 */
	public function makeActivationLink(User $u)
	{
		return $this->createAbsoluteUrl('/user/registration/activation',array(
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
}