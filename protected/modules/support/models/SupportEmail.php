<?php

/**
 * This is the model class for table "support_email".
 *
 * The followings are the available columns in table 'support_email':
 * @property string $id
 * @property string $to
 * @property string $from
 * @property string $message_id
 * @property string $subject
 * @property string $headers
 * @property string $template_id
 * @property string $message_text
 * @property string $message_html
 * @property integer $sent
 * @property integer $opened
 * @property string $opened_date
 * @property integer $bounced
 * @property string $created
 * @property string $date
 */
class SupportEmail extends NActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SupportEmail the static model class
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
		return '{{support_email}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sent, opened, bounced', 'numerical', 'integerOnly'=>true),
			array('to, from, message_id, subject', 'length', 'max'=>255),
			array('template_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, to, from, message_id, subject, headers, template_id, message_text, message_html, sent, opened, opened_date, bounced, created, date', 'safe', 'on'=>'search'),
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
			'id' => 'Email',
			'to' => 'Email To',
			'from' => 'Email From',
			'message_id' => 'Email Message',
			'subject' => 'Email Subject',
			'headers' => 'Email Headers',
			'template_id' => 'Email Template',
			'message_text' => 'Email Message Text',
			'message_html' => 'Email Message Html',
			'sent' => 'Email Sent',
			'opened' => 'Email Opened',
			'opened_date' => 'Email Opened Date',
			'bounced' => 'Email Bounced',
			'created' => 'Email Created',
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
		$criteria->compare('to',$this->to,true);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('message_id',$this->message_id,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('headers',$this->headers,true);
		$criteria->compare('template_id',$this->template_id,true);
		$criteria->compare('message_text',$this->message_text,true);
		$criteria->compare('message_html',$this->message_html,true);
		$criteria->compare('sent',$this->sent);
		$criteria->compare('opened',$this->opened);
		$criteria->compare('opened_date',$this->opened_date,true);
		$criteria->compare('bounced',$this->bounced);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * decides whether to render the text or the html version of the message
	 * if the html version exists it uses this as the preference.
	 * @return string message 
	 */
	public function message(){
		// TODO: implement message settings to render text or html message by default
		if($this->message_html !== null || $this->message_html != ''){
			return $this->message_html;
		}
		$md = new CMarkdown();
		return $md->transform($this->message_text);
	}
	
	
	public function getPreviewText(){
		//strip silly long strings 
		$totalTxt = substr($this->message_text, 0, 500);
		return preg_replace("/([^\s]{14})/"," ",$totalTxt);
	}
	
}