<?php

/**
 * This is the model class for table "timesheet_timesheet".
 *
 * The followings are the available columns in table 'timesheet_timesheet':
 * @property string $id
 * @property string $week_date
 * @property string $status
 *
 * The followings are the available model relations:
 * @property TimesheetTimerecord[] $timesheetTimerecords
 */
class TimeSheetTimesheet extends NActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return TimesheetTimesheet the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'timesheet_timesheet';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array(
				'status',
				'length',
				'max'=>15
			),
            array(
				'week_date',
				'safe'
			),
            array(
				'id, week_date, status',
				'safe',
				'on'=>'search'
			),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'timesheetTimerecords' => array(
				self::HAS_MANY, 
				'TimesheetTimerecord', 
				'timesheet_id'
			),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'week_date' => 'Week Date',
            'status' => 'Status',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models 
	 * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('id',$this->id,true);
        $criteria->compare('week_date',$this->week_date,true);
        $criteria->compare('state',$this->state,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'week_date' => "datetime",
				'status' => "ENUM('STATE_ACTIVE','STATE_SUBMITTED')",
			),
			'keys' => array());
	}
} 