<?php

/**
 * This is the model class for table "support_ticket_email".
 *
 * The followings are the available columns in table 'support_ticket_email':
 * @property string $id
 * @property string $email_id
 * @property string $ticket_id
 * @property string $type
 */
class SupportTicketEmail extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TicketEmail the static model class
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
		return '{{support_ticket_email}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email_id, ticket_id', 'required'),
			array('email_id, ticket_id', 'length', 'max'=>11),
			array('type', 'length', 'max'=>13),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email_id, ticket_id, type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'email'=>array(self::HAS_ONE,'SupportEmail','email_id'),
			'ticket'=>array(self::HAS_ONE,'SupportTicket','ticket_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email_id' => 'Email',
			'ticket_id' => 'Ticket',
			'type' => 'Type',
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
		$criteria->compare('email_id',$this->email_id,true);
		$criteria->compare('ticket_id',$this->ticket_id,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}