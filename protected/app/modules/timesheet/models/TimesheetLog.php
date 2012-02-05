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
				'task_id'=>'int',
				'minutes'=>'int'
			)
		);
	}
	
	
	/**
	 * Get all time logs for a particular week. The week is defined by the first Monday.
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
			'condition'=>"date between '$startDate' and '$endDate' and `user_id`=$userId",
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
	
	
	/**
	 * Saves a group of logs representing a timesheet week
	 * @see self::findAllForWeek to return all logs for the timesheet week.
	 * 
	 * @param array $log 
	 * $log = array(
	 *		'date'=>'2012-01-30',
	 *		0 => array(
	 *			'task'=>'1',    // task id
	 *			'project'=>'1', // project id
	 *			'time'=>array(
	 *				// worked 20 hours with 4 hours per day on project id 1
	 *				0=>4, // mon
	 *				1=>4, // tue
	 *				2=>4, // wed
	 *				3=>4, // thu
	 *				4=>4, // fri
	 *				5=>4, // sat
	 *				6=>0, // sun
	 *			)
	 *		),
	 *      0 => array(
	 *			'task'=>'2',
	 *			'project'=>'2',
	 *			'time'=>array(
	 *				// worked 20 hours on project id 2
	 *				0=>4,
	 *				1=>4,
	 *				2=>4,
	 *				3=>4,
	 *				4=>4,
	 *				5=>4,
	 *				6=>0,
	 *			)
	 *		)
	 *	)
	 */
	public function saveWeekLog($logs){
		$d = NTime::dateToUnix($logs['date']);
		$date = date('Y-m-d',mktime(0, 0, 0, date('m', $d), date('j', $d)+$i, date('Y', $d)));
		foreach($logs as $log){
			if(is_array($log['time'])) {
				foreach($log['time'] as $i=>$day){
					if($log['time'][$i]!=''){
						$l = new TimesheetLog;
						$l->minutes = $log['time'][$i]*60;
						$l->project_id = $log['project'];
						$l->task_id = $log['task'];
						$l->date = $date;
						$l->user_id = Yii::app()->user->record->id;
						$l->save();
					}
				}
			}
		}
	}
	
}

