<?php
/**
 * A timesheet can have many "time records"
 *
 * The followings are the available columns in table 'timesheet_timerecord':
 * @property string $id
 * @property string $timesheet_id
 * @property double $time_monday
 * @property double $time_tuesday
 * @property double $time_wednesday
 * @property double $time_thursday
 * @property double $time_friday
 * @property double $time_saturday
 * @property double $time_sunday
 * @property string $time_added
 * @property integer $task_id
 * @property integer $project_id
 *
 * The followings are the available model relations:
 * @property TimesheetTimesheet $timesheet
 */
class TimesheetTimerecord extends NActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return TimesheetTimerecord the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{timesheet_timerecord}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(
				'timesheet_id',
				'required'
			),
            array(
				'task_id, project_id', 
				'numerical',
				'integerOnly'=>true
			),
            array(
				'time_monday, time_tuesday, time_wednesday, time_thursday, time_friday, time_saturday, time_sunday',
				'numerical'
			),
            array(
				'timesheet_id',
				'length',
				'max'=>10
			),
            array('time_added', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, timesheet_id, time_monday, time_tuesday, time_wednesday, time_thursday, time_friday, time_saturday, time_sunday, time_added, task_id, project_id', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'timesheet' => array(self::BELONGS_TO, 'TimesheetTimesheet', 'timesheet_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'timesheet_id' => 'Timesheet',
            'time_monday' => 'Time Monday',
            'time_tuesday' => 'Time Tuesday',
            'time_wednesday' => 'Time Wednesday',
            'time_thursday' => 'Time Thursday',
            'time_friday' => 'Time Friday',
            'time_saturday' => 'Time Saturday',
            'time_sunday' => 'Time Sunday',
            'time_added' => 'Time Added',
            'task_id' => 'Task',
            'project_id' => 'Project',
        );
    }
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => 'pk',
				'timesheet_id' => 'int(11)',
				'time_monday' => 'double(2,1)',
				'time_tuesday' => 'double(2,1)',
				'time_wednesday' => 'double(2,1)',
				'time_thursday' => 'double(2,1)',
				'time_friday' => 'double(2,1)',
				'time_saturday' => 'double(2,1)',
				'time_sunday' => 'double(2,1)',
				'time_added' => 'timestamp',
				'task_id' => 'int(11)',
				'project_id' => 'int(11)'
			),
			'keys' => array());
	}
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('id',$this->id,true);
        $criteria->compare('timesheet_id',$this->timesheet_id,true);
        $criteria->compare('time_monday',$this->time_monday);
        $criteria->compare('time_tuesday',$this->time_tuesday);
        $criteria->compare('time_wednesday',$this->time_wednesday);
        $criteria->compare('time_thursday',$this->time_thursday);
        $criteria->compare('time_friday',$this->time_friday);
        $criteria->compare('time_saturday',$this->time_saturday);
        $criteria->compare('time_sunday',$this->time_sunday);
        $criteria->compare('time_added',$this->time_added,true);
        $criteria->compare('task_id',$this->task_id);
        $criteria->compare('project_id',$this->project_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}