<?php

/**
 * This is the model class for table "support_ticket".
 *
 * The followings are the available columns in table 'support_ticket':
 * @property string $id
 * @property string $subject
 * @property string $message
 * @property string $from
 * @property string $priority
 * @property string $status
 * @property string $created
 * @property integer $answered
 */
class SupportTicket extends NActiveRecord
{
	
	const PRIORITY_LOW       = 'LOW';
	const PRIORITY_NORMAL    = 'NORMAL';
	const PRIORITY_HIGH      = 'HIGH';
	const PRIORITY_EMERGENCY = 'EMERGENCY';
	
	const STATUS_OPEN   = 'OPEN'; 
	const STATUS_CLOSED = 'CLOSED';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return SupportTicket the static model class
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
		return '{{support_ticket}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('subject, message, from', 'required'),
//			array('answered', 'numerical', 'integerOnly'=>true),
//			array('subject, from', 'length', 'max'=>255),
//			array('priority', 'length', 'max'=>18),
//			array('status', 'length', 'max'=>13),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subject, message, from, priority, status, created, answered', 'safe', 'on'=>'search'),
		);
	}

	public function scopes(){
//		return array(
//			'limit'=>30
//		);
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'emails'=>array(self::MANY_MANY, 'SupportEmail', 'support_ticket_email(ticket_id,email_id)', 'order'=>'date DESC')
		);
	}


	public function  defaultScope() {
		return array(
			'order'=>'date DESC',
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subject' => 'Subject',
			'message' => 'Message',
			'from' => 'From',
			'priority' => 'Priority',
			'status' => 'Status',
			'created' => 'Created',
			'answered' => 'Answered',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('priority',$this->priority,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('answered',$this->answered);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function createTicketFromMail(SupportEmail $m){
		if($this->getIsNewRecord()){
			$this->subject = $m->subject;
		}else{
			// is a reply: found the related ticket
			// set answered to false (becuase you have a new reply!)
			$this->ticket_answered = false;
		}

		$this->from = $m->from;
		$this->date = $m->date;
		$this->status = SupportTicket::STATUS_OPEN;
		$this->priority = SupportTicket::PRIORITY_NORMAL;
		$this->save();
	}
	
	/**
	 * Displays a nicely formatted from name, if no from name present falls 
	 * back to a formatted email address. Will remove the host iinformation from email adrress
	 * so steve@newicon.net would be displayed as steve.
	 * @return string 
	 */
	public function getFrom(){
		$f = NMailReader::splitFromHeader($this->from);
		if(empty($f['name']) && empty($f['email'])){
			// format raw header to remove emai host from email
			preg_match('/(.*)@/',$this->from, $macthes);
			if(array_key_exists(1, $macthes)){
				return $macthes[1];
			}
		}
		return $f['name'];
	}
	
	/**
	 *
	 * @return SupportEmail 
	 */
	public function getRecentEmail(){
		if($this->emails)
			return $this->emails[0];
		else
			return null;
	}
	
	
}