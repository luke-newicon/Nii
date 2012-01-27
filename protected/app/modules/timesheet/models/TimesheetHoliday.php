<?php
/**
 * This model represents holiday requests. 
 *
 * The followings are the available columns in table 'timesheet_holidays':
 * @property integer $id Unique id of a holiday
 * @property integer $user_id id of the user the holiday entitlement relates to
 * @property string $date_start The date/time the holday starts
 * @property string $date_end The date/time the holiday ends (not the date the 
 * user returns)
 * @property string $status The status of the holiday request
 * @property integer $authorised_by The id of the user who authorises the 
 * holiday
 * @property string $authorised_date The date the holiday was authorised
 * @property string $comment A user submitted comment (optional) describing
 * the reasson for their holiday request
 */
class TimesheetHoliday extends NActiveRecord
{
    public static function model($className=__CLASS__){
		return parent::model($className);
    }

    public function tableName(){return '{{timesheet_holiday}}';}
	
	public function rules()
    {
        return array(
            array(
				'user_id, authorised_by',
				'numerical',
				'integerOnly'=>true
			),
            array(
				'status',
				'length',
				'max'=>15
			),
            array(
				'date_start, date_end, authorised_date, comment',
				'safe'
			),
            array(
				'id, user_id, date_start, date_end, status, authorised_by, authorised_date, comment',
				'safe',
				'on'=>'search'
			)
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'date_start' => 'Start Date',
            'date_end' => "End Date",
			'status' => "Status",
			'authorised_by'=>'Authorised by',
			'authorised_date'=>'Authorised date'
        );
    }
	
	/**
	 * Installs the table schema
	 * @param type $className 
	 */
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'user_id' => "int",
				'date_start' => "datetime",
				'date_end' => "datetime",
				'status' => "ENUM('STATUS_DRAFT','STATUS_SUBMITED','STATUS_REJECTED','STATUS_APPROVED')",
				'authorised_by'=>'int',
				'authorised_date'=>'datetime',
				'comment'=>'text'
			),
			'keys' => array()
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

        $criteria->compare('id',$this->id);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('date_start',$this->date_start,true);
        $criteria->compare('date_end',$this->date_end,true);
        $criteria->compare('status',$this->status,true);
        $criteria->compare('authorised_by',$this->authorised_by);
        $criteria->compare('authorised_date',$this->authorised_date,true);
        $criteria->compare('comment',$this->comment,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}