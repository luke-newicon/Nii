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
class PlanBox extends NWidget 
{
	
	
	/**
	 * if this is null it will be populated by the logged in users plan
	 * @var string the plan code 
	 */
	public $plan;
	
	/**
	 * whether the show the upgrade or downgrade view based on the current users plan
	 * @var boolean
	 */
	public $upgradeDowngrade = false;
	/**
	 * this 
	 * @var string 
	 */
	public $view = 'plan';
	
	
	public function run(){
		
		if ($this->plan === null)
			$this->plan = Yii::app()->user->record->plan;
		
		$plan = Plan::getPlan($this->plan);
		
		// mode upgrade-downgrade choose whther to show an upgrade or downgrade view based on the users plan
		if($this->upgradeDowngrade){
			if(Plan::isUpgradePlan($this->plan))
				$this->view = 'upgrade';
			elseif(Plan::isDowngradePlan($this->plan))
				$this->view = 'downgrade';
			else
				$this->view = 'current';
		}
		
		$this->render($this->view, array('plan'=>$plan));
	}

	
}