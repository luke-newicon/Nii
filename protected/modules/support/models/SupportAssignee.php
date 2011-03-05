<?php

/**
 * This is the model class for table "support_email".
 *
 * The followings are the available columns in table 'support_email':
 * @property string $email_id
 * @property string $email_to
 * @property string $email_from
 * @property string $email_message_id
 * @property string $email_subject
 * @property string $email_headers
 * @property string $email_template_id
 * @property string $email_message_text
 * @property string $email_message_html
 * @property integer $email_sent
 * @property integer $email_opened
 * @property string $email_opened_date
 * @property integer $email_bounced
 * @property string $email_created
 */
class SupportAssignee extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SupportAssignee the static model class
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
		return '{{support_assignee}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email_to, email_from, email_message_id, email_subject, email_headers, email_template_id, email_message_text, email_message_html, email_sent, email_opened, email_opened_date, email_bounced, email_created', 'required'),
			array('email_sent, email_opened, email_bounced', 'numerical', 'integerOnly'=>true),
			array('email_to, email_from, email_message_id, email_subject', 'length', 'max'=>255),
			array('email_template_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('email_id, email_to, email_from, email_message_id, email_subject, email_headers, email_template_id, email_message_text, email_message_html, email_sent, email_opened, email_opened_date, email_bounced, email_created', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'email_id' => 'Email',
			'email_to' => 'Email To',
			'email_from' => 'Email From',
			'email_message_id' => 'Email Message',
			'email_subject' => 'Email Subject',
			'email_headers' => 'Email Headers',
			'email_template_id' => 'Email Template',
			'email_message_text' => 'Email Message Text',
			'email_message_html' => 'Email Message Html',
			'email_sent' => 'Email Sent',
			'email_opened' => 'Email Opened',
			'email_opened_date' => 'Email Opened Date',
			'email_bounced' => 'Email Bounced',
			'email_created' => 'Email Created',
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

		$criteria->compare('email_id',$this->email_id,true);
		$criteria->compare('email_to',$this->email_to,true);
		$criteria->compare('email_from',$this->email_from,true);
		$criteria->compare('email_message_id',$this->email_message_id,true);
		$criteria->compare('email_subject',$this->email_subject,true);
		$criteria->compare('email_headers',$this->email_headers,true);
		$criteria->compare('email_template_id',$this->email_template_id,true);
		$criteria->compare('email_message_text',$this->email_message_text,true);
		$criteria->compare('email_message_html',$this->email_message_html,true);
		$criteria->compare('email_sent',$this->email_sent);
		$criteria->compare('email_opened',$this->email_opened);
		$criteria->compare('email_opened_date',$this->email_opened_date,true);
		$criteria->compare('email_bounced',$this->email_bounced);
		$criteria->compare('email_created',$this->email_created,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}