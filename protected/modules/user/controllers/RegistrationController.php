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
						$activation_url = $this->createAbsoluteUrl('/user/index/activation',array("activekey" => NData::base64UrlEncode($model->activekey), "e" => NData::base64UrlEncode($model->email)));
						UserModule::sendMail($model->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
					}

					if (($module->loginNotActive ||($module->activeAfterRegister && $module->sendActivationMail==false))
						&&$module->autoLogin) {
						$identity=new UserIdentity($model->username,$soucePassword);
						$identity->authenticate();
						Yii::app()->user->login($identity,0);
						$this->redirect($module->returnUrl);
					} else {
						if (!$module->activeAfterRegister && !$module->sendActivationMail) {
							Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
						} elseif($module->activeAfterRegister && $module->sendActivationMail==false) {
							Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),$module->loginUrl))));
						} elseif($module->loginNotActive) {
							Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
						} else {
							Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
						}
						$this->refresh();
					}
				}
			}
			$this->render('/user/registration',array('model'=>$model,'contact'=>$contact));
		}
	}


}