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
 * @property string $references
 * @property string $replyto
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
//			array('sent, opened, bounced', 'numerical', 'integerOnly'=>true),
//			array('to, from, message_id, subject', 'length', 'max'=>255),
//			array('template_id', 'length', 'max'=>11),
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
			'to' => 'To:',
			'cc' => 'Cc:',
			'from' => 'From:',
			'subject' => 'Subject:',
			'message_html' => 'Message:',
			'message_id' => 'Email Message',
			'headers' => 'Email Headers',
			'template_id' => 'Email Template',
			'message_text' => 'Message Text',
			'message_html' => 'Message',
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
		if($this->message_html !== null && $this->message_html != ''){
			// TODO: purify the html output
			$pattern = "/<(a)([^>]+)>/i";
			$replacement = "<\\1 target=\"_blank\"\\2>";
			$html = preg_replace($pattern,$replacement,str_replace('target="_blank"','',$this->message_html));
			$p = new CHtmlPurifier();
			return $html;//$p->purify($html);
		}
		$md = new NMarkdown();
		return $md->transform($this->message_text);
	}
	
	/**
	 * Returns a string of text representing a preview of the email
	 * @return string
	 */
	public function getPreviewText(){
		// strip silly long strings
		$totalTxt = ($this->message_text)? $this->message_text:strip_tags($this->message_html);
		return NHtml::encode(NHtml::previewText($totalTxt, 500));
	}


	public function cc()
	{
		return NMailReader::getRecipients($this->cc);
	}

	public function to()
	{
		return NMailReader::getRecipients($this->to);
	}
	
	/**
	 * Displays a nicely formatted from name, if no from name present falls 
	 * back to a formatted email address. Will remove the host information from email adrress
	 * so steve@newicon.net would be displayed as steve.
	 * @return string 
	 */
	public function getFrom(){
		$f = NMailReader::splitRecipient($this->from);
		return $f['name'];
	}
	
	/**
	 * gets the correct contact based on either an id or an email
	 * @param type $idOrEmail 
	 */
	public static function getContact($idOrEmail){
		if(is_numeric($idOrEmail)){
			// assume id
			$c = CrmContact::model()->findByPk($idOrEmail);
		}else{
			// assume email text string
			// ok so if our lookup is any good then
			// this string should not be any users details
			// OR an email that currently exists in the system and
			// is attached to a contact.......
			// ... so lets add it.
			$c = new CrmContact;
			$c->first_name = NMailReader::removeEmailHost($idOrEmail);
			$c->save();
			$c->saveEmailAddress($idOrEmail);

		}
			
	}
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
	public function schema(){
		return array(
			'columns'=>array(
				'id'=>'pk',
				'to'=>'text',
				'cc'=>'text',
				'from'=>'string',
				'message_id'=>'string',
				'subject'=>'string',
				'headers'=>'text',
				'message_text'=>'longtext',
				'message_html'=>'longtext',
				'sent'=>'boolean',
				'opened'=>'boolean',
				'opened_date'=>'datetime',
				'bounced'=>'boolean',
				'created'=>'datetime',
				'date'=>'datetime',
				'references'=>'text',
				'in_reply_to'=>'string',
				'test_col'=>'string'
			),
			'keys'=>array(
				array('subject')
			)
		);
	}
	
}