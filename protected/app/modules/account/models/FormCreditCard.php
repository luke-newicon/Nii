<?php

Class FormCreditCard extends CFormModel
{
	public $number;
	public $year;
	public $month;
	public $verification_value;
	
	/**
	 * this attribute is used solely to display the expiration date validation message
	 * @var type 
	 */
	public $validExpirationDate;
	
	public function rules(){
		return array(
			// card numbers can be between 14 and 19 characters long.  
			// BUT we are allowing dashes and spaces so we should add a bit to the upper limit.
			array('number', 'length', 'min'=>14, 'max'=>24),
			array('number', 'match', 'pattern'=>'/^([0-9- ])+$/', 'message'=>'Only use numbers in your card number'),
			array('number', 'luhnValid'),
			array('number, year, month, verification_value', 'required'),
			array('year,month', 'validateDate'),
		);
	}
	
	public function attributeLabels(){
		return array(
			'number'=>'Credit Card Number',
			'year'=>'Expires Year',
			'month'=>'Expires Month',
			'verification_value'=>'CVV',
			'validExpirationDate'=>'Valid Expiration Date'
		);
	}
	
	public function getMonths(){
		$m = array();
		for ($i = 1; $i <= 12; $i ++) {
			$m[$i] = date("m", mktime (0,0,0,$i,1)) . ' - ' . date("F", mktime (0,0,0,$i,1));
		}
		return $m;
	}
	
	public function getYears(){
		$year = array();
		for ($i = 0; $i <= 10; $i ++){
			$y = date("Y", mktime (0,0,0,1,1,date('Y',time()) + $i));
			$year[$y] = $y;
		}
		return $year;
	}
	
	
	/**
	 * check the expirery date is greater than todays date
	 * @param type $attribute
	 * @param type $params 
	 */
	public function validateDate($attribute,$params){
		$today = time();
		$expires = mktime(0, 0, 0, $this->month+1, 0, $this->year);
		if($today > $expires){
			$this->addError ('validExpirationDate', 'This must be in the future!');
		}
	}
	
	/**
	 * Test for Luhn validation
	 */
	public function luhnValid($attribute, $params) {
		$digits = preg_replace('/[^0-9]/', '', $this->number);
		if(!$this->isLuhnValid($digits))
			$this->addError('number', 'This card number is not valid');
	}

	
	
	
	# http://en.wikipedia.org/wiki/Luhn_algorithm
	public function isLuhnValid($str){
		if (strspn($str, "0123456789") != strlen($str)) {
		  return false; // non-digit found
		}
		$map = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, // for even indices
					 0, 2, 4, 6, 8, 1, 3, 5, 7, 9); // for odd indices
		$sum = 0;
		$last = strlen($str) - 1;
		for ($i = 0; $i <= $last; $i++) {
		  $sum += $map[$str[$last - $i] + ($i & 1) * 10];
		}
		return $sum % 10 == 0;
	}
	
}