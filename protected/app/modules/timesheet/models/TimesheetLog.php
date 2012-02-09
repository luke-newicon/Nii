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
	 *		// date of the first monday. i.e. the week commencing monday the 30th. The following log in position 0 will represent the log for monday, 1 for tuesday etc.
	 *		'date'=>'2012-01-30',
	 *		// format of each time log, can be time:'the time in H:MM', minutes:'the time in minutes', hours:'the time in hours'
	 *		// if empty assumes hours
	 *		'format' => one of ('time', 'minutes', 'hours')
	 *		0 => array(
	 *			'task'=>'1',    // task id or text (to create a new task)
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
	 *      1 => array(
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
		foreach($logs as $log){
			if(is_array($log['time'])) {
				// check logs for monday to sunday 0=>monday - 6=>sunday
				for($i=0; $i<=6; $i++){
					if(array_key_exists($i, $log['time']) && $log['time'][$i]!=''){
						$l = new TimesheetLog;
						
						// work out the total minutes based on supplied format
						switch ($logs['format']) {
							case 'time':
								$l->minutes = NTime::timeToMinutes($log['time'][$i]);
							break;
							case 'minutes':
								$l->minutes = $log['time'][$i];
							break;
							default:
								$l->minutes = $log['time'][$i]*60;
						}
						
						if($logs['format']=='hours')
							$l->minutes = $log['time'][$i]*60;
						
						
						$l->project_id = $log['project'];
						
						if(!is_numeric($log['task'])){
							// check if the number is an id and exists in the tasks db?
							$taskId = Yii::app()->getModule('project')->createTask($log['project'], array(
								'name'=>$log['task'],
								'created_by_id'=>Yii::app()->user->record->id
							));
							$log['task'] = $taskId;
						}
													
						$l->task_id = $log['task'];
						$l->date = date('Y-m-d',mktime(0, 0, 0, date('m', $d), date('j', $d)+$i, date('Y', $d)));
						$l->user_id = Yii::app()->user->record->id;
						$l->save();
					}
				}
			}
		}
	}
	
	/**
	 * deletes a row of logs for the timesheet.
	 * Logs are grouped by project and task id.
	 * 
	 * @param int $projectId
	 * @param int $taskId
	 * @param mixed $dateCommencing timestamp or string in mysql format
	 * @param int $userId | null use current user id
	 */
	public function deleteWeekLog($projectId, $taskId, $dateCommencing, $userId=null){
		if($userId==null)
			$userId = Yii::app()->user->record->id;
		
		if(is_string($dateCommencing))
			$startDate = NTime::dateToUnix($dateCommencing);
		
		$endDate = date('Y-m-d',mktime(0, 0, 0, date('m', $startDate), date('j', $startDate)+6, date('Y', $startDate)));
		
		$this->deleteAllByAttributes(
			array('project_id'=>$projectId, 'task_id'=>$taskId),
			'date between :startDate and :endDate and `user_id` = :userId',
			array(':startDate'=>$startDate, ':endDate'=>$endDate, ':userId'=>$userId)
		);
				
	}
	
}

