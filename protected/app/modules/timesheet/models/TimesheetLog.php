<?php

/**
 * Description of TimesheetLog
 *
 * @author steve
 */
class TimesheetLog extends NActiveRecord
{
	
	public function tableName(){
		return '{{timesheet_log}}';
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public static function install($className = __CLASS__) {
		parent::install($className);
	}
	
	public function schema() {
		return array(
			'columns'=>array(
				'id'=>'pk',
				'user_id'=>'int',
				'date'=>'datetime',
				'project_id'=>'int',
				'task_id'=>'int'
			)
		);
	}
	
	
	/**
	 * Get all time logs for a particular week.
	 * 
	 * @param unix time $commencing 
	 * - the first monday of the week you wish to retrieve records for.
	 * - optional: if not specified $comencing will default to the monday of the current week
	 * @return array TimesheetLog active record classes 
	 */
	public function findAllForWeek($commencing=null, $userId=null){
		if($commencing===null)
			$commencing = $this->getMonday();
		if($userId===null)
			$userId = Yii::app()->user->record->id;
		$startDate = date('Y-m-d',$commencing);
		$endDate = date('Y-m-d',mktime(0,0,0,date('m',$commencing),date('d',$commencing)+6, date('Y',$commencing)));
		return TimesheetLog::model()->findAll(array(
			'condition'=>"date between '$commencing' and '$endDate' and `user_id`=$userId",
			'order'=>'project_id'
		));
	}
	
	/**
	 * Get the monday for this week
	 * 
	 * @return unix timestamp for the monday of the current week
	 */
	public function getMonday(){
		if(date('w') == 1)
			return time();
		return strtotime('last monday');
	}
	
}

