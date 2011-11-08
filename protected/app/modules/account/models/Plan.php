<?php

/**
 * Plan class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * Description of Plan
 *
 * @author steve
 */
class Plan {
	
	public static $plans = array(
		'hotspot-free'=>array(
			'code'=>'hotspot-free',
			'id'=>0,
			'title'=>'Free',
			'price'=>'free',
			'projects'=>1,
			'collaborators'=>1
		),
		'hotspot-starter'=>array(
			'code'=>'hotspot-starter',
			'id'=>1,
			'title'=>'Starter',
			'price'=>4.00,
			'projects'=>3,
			'collaborators'=>'unlimited'
		),
		'hotspot-studio'=>array(
			'code'=>'hotspot-studio',
			'id'=>2,
			'title'=>'Studio',
			'price'=>14.00,
			'projects'=>10,
			'collaborators'=>'unlimited'
		),
		'hotspot-agency'=>array(
			'code'=>'hotspot-agency',
			'id'=>3,
			'title'=>'Agency',
			'price'=>49.00,
			'projects'=>25,
			'collaborators'=>'unlimited'
		),
		'hotspot-max'=>array(
			'code'=>'hotspot-max',
			'id'=>4,
			'title'=>'Max',
			'price'=>125.00,
			'projects'=>'unlimited',
			'collaborators'=>'unlimited'
		)
	);
	
	public static function getPlan($code){
		if(array_key_exists($code, Plan::$plans))
			return Plan::$plans[$code];
		else
			return Plan::$plans['hotspot-free'];
	}
	
	public static function isCurrentPlan($plan){
		$userPlan = Plan::getPlan(Yii::app()->user->record->plan);
		if(is_string($plan))
			$plan = Plan::getPlan($plan);
		return ($plan['id'] == $userPlan['id']);
	}
	
	public static function isUpgradePlan($plan){
		$userPlan = Plan::getPlan(Yii::app()->user->record->plan);
		if(is_string($plan))
			$plan = Plan::getPlan($plan);
		return ($plan['id'] > $userPlan['id']);
	}
	
	public static function isDowngradePlan($plan){
		$userPlan = Plan::getPlan(Yii::app()->user->record->plan);
		if(is_string($plan))
			$plan = Plan::getPlan($plan);
		return ($plan['id'] < $userPlan['id']);
	}
	
	/**
	 * returns the users next upgrade plan
	 * @param type $plan 
	 * @return array plan or null if no upgrade plan available
	 */
	public static function getNextPlan(){
		$plan = Yii::app()->user->account->plan;
		foreach (Plan::$plans as $p) {
			if ($p['id'] == ($plan['id']+1))
				return $p;
		}
		return null;
	}
	
	/**
	 * returns the users previous (downgrade) plan
	 * @param type $plan 
	 * @return array plan or null if no downgrade plan available
	 */
	public static function getPrevPlan(){
		$plan = Yii::app()->user->account->plan;
		foreach (Plan::$plans as $p) {
			if ($p['id'] == ($plan['id']-1))
				return $p;
		}
		return null;
	}
	
}