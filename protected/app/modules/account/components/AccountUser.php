<?php

/**
 * UserBehaviour class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Account specific NWebUser functions
 *
 * @author steve
 */
class AccountUser extends CBehavior
{	
	/**
	 * get the recurly account code for this user
	 * (should be put into a recurly user behaviour)
	 * @return string user recurly account code
	 */
	public function getAccountCode(){
		// must be unique to the user and must not change!
		return 'hotspot-' . Yii::app()->user->record->id;
		//return Yii::app()->user->record->email;
	}
	
	/**
	 * Gets the plan information for the current user
	 * @return array;
	 */
	public function getPlan(){
		return Plan::getPlan(Yii::app()->user->record->plan);
	}
	
	/**
	 * Get the number of days left in the trial
	 * If the trial has expired it will return 0
	 * @return int number of days left
	 */
	public function getTrialDaysLeft(){
		$ends = CDateTimeParser::parse(Yii::app()->user->record->trial_ends_at, 'yyyy-MM-dd hh:mm:ss');
		$today = time();
		$secondsLeft = $ends - $today;
		
		if($secondsLeft <= 0)
			$secondsLeft = 0;
		$daysLeft = ceil($secondsLeft/(60*60*24));
		
		return $daysLeft;
	}
	
	/**
	 * return true if the trial has expired or false
	 * @return boolean 
	 */
	public function trialExpired(){
		return ($this->owner->record->trial && ($this->getTrialDaysLeft() == 0));
	}
	
	/**
	 * returns true or false if the user is currently in a trial mode
	 * @return boolean
	 */
	public function InTrial(){
		return (Yii::app()->user->record->trial);
	}
	
}