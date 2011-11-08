<?php

/**
 * trialMessage class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of trialMessage
 *
 * @author steve
 */
class TrialMessage extends NWidget 
{
	public function run(){
		
		// if the user is not on a trial return
		if (!Yii::app()->user->record->trial) 
			return;
			
		
		$daysLeft = Yii::app()->user->account->getTrialDaysLeft();
		

			
		// determine the plan to activate to after trial
		// if the user is currently on the free plan then they have to upgrade to the starter plan.
		$plan = Yii::app()->user->record->plan;
		if ($plan == 'hotspot-free')
			$plan = 'hotspot-starter';
		
		
		if($daysLeft == 0) {
			echo '<div class="trial">Your trial has ended, <a class="label important" onclick="userAccountView.upgradeTo(\''.$plan.'\');return false;" href="#" style="color:#fff;text-decoration:underline;">activate now</a></div>';
		} else {
			$days = ($daysLeft==1)?'day':'days';
			echo '<div class="trial">Trial Ends in '.$daysLeft.' '.$days.', or <a onclick="userAccountView.upgradeTo(\''.$plan.'\');return false;" href="#" style="color:#fff;text-decoration:underline;">activate now</a></div>';
		}
		
		
	}
}