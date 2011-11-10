<?php

Class Billing extends NActiveRecord
{
	
	public $country = 'GB';
	
	public function rules(){
		return array(
			array('address2, country, state, card_expires_year, card_expires_month, card_last_four, current_period_ends_at, card_type, data', 'safe'),
			array('first_name, last_name, address1, city, zip, country', 'required')
		);
	}
	
	public function attributeLabels(){
		return array(
			'first_name'=>'First Name on Card',
			'last_name'=>'Last Name on Card',
			'address1'=>'Street Address',
			'address2'=>'Address 2',
			'city'=>'City',
			'zip'=>'Postal/Zip',
			'country'=>'Country',
			'state'=>'County/State'
		);
	}
	
	/**
	 * Get the text name of the country e.g. 'United Kingdom'
	 * @return string 
	 */
	public function getCountryName(){
		$c = $this->getCountries();
		return $c[$this->country];
	}
	
	public function getCountries(){
		return NData::countries();
	}
	
	
	/**
	 * http://www.merriampark.com/anatomycc.htm
	 * also: http://en.wikipedia.org/wiki/Credit_card_numbers
	 * 
	 * referencing the first 6 digits of the card number we can work out the card type from the following:
	 * diners_club      : 300-305, 36, 38 
	 * american_express	: 34, 37
	 * visa				: 4
	 * master			: 51-55
	 * discover	        : 65, 6011, 644-649, 622126-622925	
	 * jcb	            : 3528-3589 
	 * maestro          : 5018, 5020, 5038, 6304, 6759, 6761, 6762, 6763
	 * switch           : 4903, 4905, 4911, 4936, 564182, 633110, 6333, 6759
	 * solo             : 6334, 6767
	 * laser            : 6304, 6706, 6771, 6709
	 * 
	 * @param string first 6 digits of the card number
	 * @return string card type (same as recurly)
	 * visa, master, american_express, discover, diners_club, jcb, maestro, switch, solo, laser, and Unknown
	 */
	public function getCardType($firstSix){
		$firstSix = str_replace(array(' ', '-'), '', $firstSix);
		// check if visa
		if(substr($firstSix,0,1) == '4'){
			return 'visa';
		}
		
		// check if master card
		$two = substr($firstSix,0,2);
		if($two >= 51 && $two <= 55){
			return 'master';
		}
		
		// check if american_express
		if($two == '34' || $two == '37'){
			return 'american_express';
		}
		
		// check if discover
		$four = substr($firstSix,0,4);
		$three = substr($firstSix,0,3);
		if($two == '65' || $four == '6011' || $three >= 644 && $three <= 649 || $firstSix >= 622126 && $firstSix <= 622925){
			return 'discover';
		}
		
		// check if diners_club
		if($two == '36' || $two == '38' || $three >= 300 && $three <= 305){
			return 'diners_club';
		}
		
		
		// check if jcb // 3528-3589 
		if($four >= 3528 && $four <= 3589){
			return 'jcb';
		}
		
		// check if maestro 	
		if($four == '5018' || $four == '5020' || $four == '5020' || $four == '5038' || $four == '6304' || $four == '6759' 
		|| $four == '6761' || $four == '6762' || $four == '6763'){
			return 'maestro';
		}
		
		// check if switch
		if($four == '4903' || $four == '4905' || $four == '4911' || $four == '4936' || $four == '564182' || $four == '633110' 
		|| $four == '6333' || $four == '6759'){
			return 'switch';
		}
		
		// check if solo
		if($four == '6334' || $four == '6767'){
			return 'solo';
		}
		
		// check if laser 
		if($four == '6304' || $four == '6706' || $four == '6771' || $four == '6709'){
			return 'laser';
		}
		
		return 'unknown';
		
	}
	
	/**
	 * before save record the users ip address
	 * @return boolean 
	 */
	public function beforeSave() {
		// add IP address details
		$this->ip_address = Yii::app()->request->getUserHostAddress();
		return parent::beforeSave();
	}
	
	/**
	 * This function populates the billing record with information form the card details
	 * Only stores information that does not require PCI compliance 
	 */
	public function addCardInfo(FormCreditCard $card){
		$this->card_expires_year = intval($card->year);
		$this->card_expires_month = intval($card->month);
		$this->card_last_four = substr($card->number, -4, 4);
		$this->card_type = $this->getCardType($card->number);
	}
	
	/**
	 * get the icon class for the card type
	 * @return string 
	 */
	public function getCardTypeImageClass(){
		// card_type can have underscores but the icon (sprite generator) class will convert them to dashes
		if($this->card_type=='')
			return 'account-unknown';
		
		$iconName = str_replace('_','-',$this->card_type);
		return 'account-'.$iconName;
	}

	
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public static function install($className=__CLASS__){
		return parent::install($className);
	}
	
	public function tableName(){
		return '{{account_billing}}';
	}
	
	
	public function schema(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'user_id'=>'int',
				'plan'=>'string',
				// this is the first name as appears on the credit card associated with this address
				'first_name'=>'string',
				'last_name'=>'string',
				'address1'=>'string',
				'address2'=>'string',
				'city'=>'string',
				'zip'=>'string',
				'state'=>'string',
				'country'=>'string',
				'ip_address'=>'string',
				// last 4 digits of the card number
				'card_last_four'=>'string', 
				// card expirery date
				'card_expires_year'=>'int',
				'card_expires_month'=>'int',
				'card_type'=>'string',
				'current_period_ends_at'=>'int', // timestamp from the subscription
				'data'=>'text'
			)
		);
	}
}