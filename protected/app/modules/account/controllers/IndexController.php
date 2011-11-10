<?php

Class IndexController extends NController
{
	
	public function init(){
		RecurlyClient::SetAuth('api-test@newicon-test.com', 'a2cc819128fe44f493fb40068e60efe6', 'newicon-test', 'sandbox');
	}
	
		
	/**
	 * used for debugging
	 * @param type $accountCode 
	 */
	public function actionIndex($accountCode){
		/*
		$s = RecurlySubscription::getSubscription($accountCode);
		dp('SUBSCRIPTION');
		dp($s);
		if($s === null)
			echo 'NO subscription';
		
		dp(date('d/m/y',$s->current_period_ends_at));
		
		Yii::beginProfile('recurly account');
		if(!($account = Yii::app()->cache->get('account:'.$accountCode))){
			$account = RecurlyAccount::getAccount($accountCode);
			if($account === null){
				// create an acount?
				$account = new RecurlyAccount($accountCode);
				$account->create();
			}
			Yii::app()->cache->set('account:'.$accountCode, $account);
		}
		Yii::endProfile('recurly account');
			
		dp($account);
		
		
		echo '<h3>invoices</h3>';
		
		Yii::beginProfile('recurly invoices');
		if(!($invoices = Yii::app()->cache->get('invoices:'.$email))){
			$invoices = $account->listInvoices();
			Yii::app()->cache->set('invoices:'.$email, $invoices);
		}
		Yii::endProfile('recurly invoices');
		
		
		
		foreach($invoices as $in){
			dp($in);
		}
		
		Yii::beginProfile('recurly billing info');
		if(!($billing = Yii::app()->cache->get('billing:'.$accountCode))){
			$billing = RecurlyBillingInfo::getBillingInfo('steve@newicon.net');
			Yii::app()->cache->set('billing:'.$accountCode, $billing);
		}
		Yii::endProfile('recurly billing info');
		
		dp($billing);
		
		Yii::beginProfile('recurly subscription info');
		if(!($subscription = Yii::app()->cache->get('subscription:'.$accountCode))){
			$subscription = RecurlySubscription::getSubscription('steve@newicon.net');
			Yii::app()->cache->set('subscription:'.$accountCode, $subscription);
		}
		Yii::endProfile('recurly subscription info');
		
		dp($subscription);
		*/
	}
	
	/**
	 * displays the billing info tab;
	 */
	public function actionBillingInfo(){
		
		$accountCode = Yii::app()->user->account->accountCode;
		
		
		$billing = Billing::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		if ($billing===null){
			// there is no point showing billing info if you havent made a purchase
			echo $this->renderPartial('_no-billing-info', array(), true);
			Yii::app()->end();
		}
		
		// get account info
		Yii::beginProfile('recurly account');
		if(!($account = Yii::app()->cache->get('account:'.$accountCode))){
			$account = RecurlyAccount::getAccount($accountCode);
			if($account === null){
				// create an acount
				$account = new RecurlyAccount($accountCode);
				$account->email = Yii::app()->user->email;
				$account->first_name = Yii::app()->user->record->first_name;
				$account->last_name = Yii::app()->user->record->last_name;
				$account->create();
			}
			Yii::app()->cache->set('account:'.$accountCode, $account);
		}
		Yii::endProfile('recurly account');
		
		// get invoice info
		Yii::beginProfile('recurly invoices');
		if(!($invoices = Yii::app()->cache->get('invoices:'.$accountCode))){
			$invoices = $account->listInvoices();
			Yii::app()->cache->set('invoices:'.$accountCode, $invoices);
		}
		Yii::endProfile('recurly invoices');
		
		
		// we have billing info
		$this->render('billing-info',array(
			'billing'=>$billing,
			'invoices'=>$invoices,
			'account'=>$account
		));
	}
	
	public function actionYourPlan(){
		
		echo $this->renderPartial('your-plan', array(), true, true);
	}
	
	/**
	 * update personal information
	 */
	public function actionPersonalInfo(){
		
		$user = Yii::app()->user->record;
		$userPassword = new UserPasswordForm();
		if($user === null)
			throw new CHttpException(404, 'User does not exist');
		
		// if the change password form is empty dont bother validating it
		if(isset($_POST['UserPasswordForm']['password']) && $_POST['UserPasswordForm']['password'] != '')
			$this->performAjaxValidation(array($user,$userPassword) , 'user-form');
		else
			$this->performAjaxValidation($user , 'user-form');
		
		// form submited to update user details
		if (Yii::app()->request->getIsPostRequest() && isset($_POST['User'])) {
			$user->attributes = $_POST['User'];
			// handle password change
			$userPassword->attributes = $_POST['UserPasswordForm'];
			if ($userPassword->validate()) {
				$user->password = UserModule::passwordCrypt($userPassword->password);
			}
			$user->save();
		}
		
		echo $this->renderPartial('personal-info', array('user'=>$user, 'userPassword'=>$userPassword), true, true);
	}
	
	
	public function actionUpgradePlan($planCode='') {
		
		if ($planCode=='') {
			// work out the next plan
			$plan = Plan::getNextPlan();
					
			// there is no next plan so we must be on the max plan!
			if($plan == null){
				echo 'You are on the max plan! There is not a bigger plan than the max plan :-)';
				return;
			}
			
			$planCode = $plan['code'];
		}
		
		// figure out if we need to take the credit card details.
		
		// do we have billing information?
		$billing = Billing::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		if ($billing===null) 
			$billing = new Billing;
		
		$card = new FormCreditCard;

		
		$this->performAjaxValidation(array($billing, $card) , 'billing-info-form');
		
		// -----------------------
		// No card details
		// -----------------------
		if($billing->getScenario() == 'insert'){
			// if we don't have billing information we need to get the credit card and billing details
			
			if (Yii::app()->request->getIsPostRequest()) {
				
				$billing->attributes = Yii::app()->request->getPost('Billing', array());
				$card->attributes = Yii::app()->request->getPost('FormCreditCard', array());

				if($billing->validate() && $card->validate()){

					// populate the reculy subscription object with the post data
					$subscription = $this->populateSubscription($planCode, $billing, $card, $account);
						
					try {
						$accountInfo = $subscription->create();
						// the transaction was successful so
						// save the billing information in our database
						$billing->user_id = Yii::app()->user->id;
						$billing->addCardInfo($card);
						$billing->current_period_ends_at = $accountInfo->current_period_ends_at;
						$billing->plan = Yii::app()->user->record->plan;
						//$billing->data = serialize($accountInfo);
						$billing->save();
						
						// update the users plan (could store in billing info)
						Yii::app()->user->record->plan = $planCode;
						Yii::app()->user->record->trial = 0;
						Yii::app()->user->record->save();
						
						echo 'Your subscription was created successfully.';
						Yii::app()->end();
					}
					catch (RecurlyValidationException $e) {
						$error = $e->getMessage();
					}
					catch (RecurlyException $e) {
						$error = "An error occurred while communicating with our payment gateway. Please try again or contact support.";
					}
				}
				
			}
			$error = isset($error)?$error:false;
			echo $this->renderPartial('upgrade-plan-card', array(
				'billing'=>$billing, 
				'card'=>$card,
				'plan'=>$planCode,
				'error'=>$error
			), true, true);
		}
		
		
		// --------------------------------
		// Card details are already stored.
		// --------------------------------
		if($billing->getScenario() == 'update'){
			// if we have billing information then we know a card has already been registered.
			// so... we want to display the cards last 4 digits
			
			// in this case lets try to upgrade
			if (Yii::app()->request->getIsPostRequest()) {
				try {
					// get the plan code from the form data
					$planCode = $_POST['planCode'];
					$sub = RecurlySubscription::changeSubscription(Yii::app()->user->account->accountCode, 'renewal', $planCode);
					Yii::app()->user->record->plan = $planCode;
					Yii::app()->user->record->trial = 0;
					Yii::app()->user->record->save();
					$p = plan::getPlan($planCode);
					if($sub){
						echo $this->renderPartial('upgrade-plan-success',array('planTitle'=>$p['title']));
					}else{
						echo $this->renderPartial('upgrade-plan-error');
					}
				} catch(RecurlyException $e) {
					echo $this->renderPartial('upgrade-plan-error');
				}
			}else{
				// show the page to confirm upgrading, allow user to change credit card details.
				echo $this->renderPartial('upgrade-plan', array(
					'billing'=>$billing, 
					'card'=>$card,
					'plan'=>$planCode
				), true, true);
			}
		}
	}
	
	
	public function actionDowngradePlan($planCode){
		// we will assume you already have a subscription
		try {
			// get the desired downgrade plan details
			$plan = Plan::getPlan($planCode);
			
			// can downgrade if the plan projects are unlimited 
			// or the current number of projects is less than or equal to the downgrade plan projects limit
			$canDowngrade = ($plan['projects'] == 'unlimited' || Project::model()->count() <= $plan['projects']);
				
			if(!$canDowngrade){
				echo 'You can not downgrade to this plan because you have too many projects. 
					This plan only enables your account to have '.$plan['projects'].' project(s). <br /> <br /> 
					If you delete some projects you will be able to downgrade.  ';
				return;
			}
				
			RecurlySubscription::changeSubscription(Yii::app()->user->account->accountCode, 'renewal', $planCode);
			Yii::app()->user->record->plan = $planCode;
			Yii::app()->user->record->save();
			// also update billing plan (silly)
			$b = Billing::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
			if($b === null)
				return false;
			else {
				$b->plan = $planCode;
				$b->save();
			}
			echo 'Downgrade successful';
		}catch(RecurlyException $e){
			echo 'Could not downgrade your account';
		}
	}
	
	
	
	/**
	 * called by ajax.
	 * action enabling the user to modify his/her billing information and credit card details
	 * 
	 * @param string $ret the action to return to on successfully updating the billing details
	 */
	public function actionChangeBilling($ret=''){
		//echo 'update your card and billing details';
		
		// do we have billing information?
		$billing = Billing::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		if ($billing===null) 
			$billing = new Billing;
		
		$card = new FormCreditCard;
		
		$this->performAjaxValidation(array($billing, $card) , 'change-billing-info-form');
		
			
		
		if(Yii::app()->request->getIsPostRequest()) {
			// populate objects with post data
			$billing->attributes = Yii::app()->request->getPost('Billing', array());
			$card->attributes = Yii::app()->request->getPost('FormCreditCard', array());
			
			$b = $billing->validate();
			$c = $card->validate();
			
			if($b && $c){
				// valid details
				$rBilling = $this->populateBilling(Yii::app()->user->account->accountCode, $billing, $card);
				try {
					// update the billing info.
					// recurly also validates the card. 
					// Recurly attempts a $1.00 authorization and voids the transaction immediately.
					$updatedBilling = $rBilling->update();
					// got this far so the update must be successful. Lets save the details.
					$billing->addCardInfo($card);
					$billing->save();
					// if ret is empty then return the page to the billing-info tab
					$ret = ($_POST['ret']=='') ? 'billing-info' : $_POST['ret'];
					echo json_encode(array('method'=>'returnTo', 'params'=>array($ret)));
					Yii::app()->end();
				}
				catch (RecurlyValidationException $e) {
					$error = $e->getMessage();
				}
				catch (RecurlyException $e) {
					$error = "An error occurred while communicating with our payment gateway. Please try again or contact support.";
				}
			}
				
		}else{
			// populate the card expirery date from the billing details on record
			// we only want to do this if there is no form post information
			if($card->year == '')
				$card->year = $billing->card_expires_year;
			if($card->month == '')
				$card->month = $billing->card_expires_month;
		}
		
		$error = isset($error)?$error:false;
		$html = $this->renderPartial('change-billing',array(
			'billing'=>$billing,
			'card'=>$card,
			'error'=>$error,
			'ret'=>$ret
		), true, true);
		echo json_encode(array('result'=>array('html'=>$html)));
		Yii::app()->end();
	}
	
	/**
	 * connects to recurly and downloads the invoice with the passed id. 
	 * Then outputs the downloaded pdf as a download link.
	 * 
	 * @param string $id 
	 */
	public function actionInvoice($id){
		// want to download the pdf invoice and display to customer
		
		$url  = RecurlyClient::__recurlyBaseUrl() . RecurlyClient::PATH_INVOICES . "$id.pdf";
		
		$path = Yii::getPathOfAlias('app.runtime.invoices');
		
		if(!is_dir($path))
			mkdir (Yii::getPathOfAlias('app.runtime').'/invoices');
		
		// could use the same file so that it is always overwriten
		$path = Yii::getPathOfAlias('app.runtime.invoices')."/tmp.pdf";
		
		$fp = fopen($path, 'w');

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/pdf; charset=utf-8',
            'Accept: application/pdf',
            "User-Agent: Recurly PHP Client v" . RecurlyClient::API_CLIENT_VERSION
        )); 

        curl_setopt($ch, CURLOPT_USERPWD, RecurlyClient::$username . ':' . RecurlyClient::$password);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		
		$data = curl_exec($ch);

		curl_close($ch);
		fclose($fp);
		
		Yii::app()->request->sendFile("$id.pdf", file_get_contents($path), 'application/pdf', true);
	}
	
	
	/**
	 * populates a recurly subscription object from the Billing model and FormCreditCard model
	 * 
	 * @see self::populateBilling
	 * @param mixed $account
	 * @param Billing $billing
	 * @param FormCreditCard $card
	 * @return RecurlySubscription 
	 */
	public function populateSubscription($planCode, Billing $billing, FormCreditCard $card, &$account){
		
		// populate recurly api objects
		$account = new RecurlyAccount(Yii::app()->user->account->accountCode);
		$account->first_name = Yii::app()->user->record->first_name;
		$account->last_name = Yii::app()->user->record->last_name;
		$account->email = Yii::app()->user->email;
		
		$subscription = new RecurlySubscription();
		$subscription->plan_code = $planCode;
		$subscription->account = $account;
		
		$subscription->billing_info = $this->populateBilling($subscription->account->account_code, $billing, $card);
		
		return $subscription;
	}
	
	
	/**
	 * creates a new Reculy billing object and populates it from the billing model and FormCreditCard model
	 * 
	 * @param string $accountCode the recurly user account code
	 * @param Billing $billing
	 * @param FormCreditCard $card
	 * @return RecurlyBillingInfo 
	 */
	public function populateBilling($accountCode, Billing $billing, $card=null){
		$rBilling = new RecurlyBillingInfo($accountCode);
		$rBilling->first_name = $billing->first_name;
		$rBilling->last_name = $billing->last_name;
		$rBilling->address1 = $billing->address1;
		$rBilling->address2 = $billing->address2;
		$rBilling->city = $billing->city;
		$rBilling->state = $billing->state;
		$rBilling->country = $billing->country;
		$rBilling->zip = $billing->zip;
		if	($card !== null) {
			$rBilling->credit_card->number = $card->number;
			$rBilling->credit_card->year = intval($card->year);
			$rBilling->credit_card->month = intval($card->month);
			$rBilling->credit_card->verification_value = $card->verification_value;
		}
		$rBilling->ip_address = Yii::app()->request->getUserHostAddress();
		return $rBilling;
	}
	
	
}