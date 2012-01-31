<?php

/**
 * Description of TimesheetLog
 *
 * @author steve
 */
class TimesheetLog extends NActiveRecord
{
	public function schema() {
		return array(
			'columns'=>array(
				'id'=>'pk',
				'user_id'=>'int',
				'date'=>'datetime',
				'time'=>'int',
				'project_id'=>'int',
				'task_id'=>'int'
			)
		);
	}
}

