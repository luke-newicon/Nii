<?php

/**
 * Description of HftEventAttendee
 *
 * @author robinwilliams
 */
class HftEventAttendee extends NActiveRecord 
{
	
/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
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
		return 'hft_event_attendee';
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'contact_id' => 'Attendee',
			'additional_attendees' => 'Number of Guests',
			'attendee_name' => 'Attendee',
			'event_id' => 'Event',
		);
	}
	
	public function relations() {
		return array(
			'contact'=>array(self::BELONGS_TO, 'HftContact', 'contact_id'),
		);
	}
	
	public function rules() {
		return array(
			array('event_id', 'required'),
			array('contact_id, attendee_name, additional_attendees', 'safe'),
		);
	}
	
	public function columns() {
		return array();
	}
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'event_id' => 'int(11)',
				'contact_id' => 'int(11)',
				'attendee_name' => "varchar(255)",
				'additional_attendees' => 'int(3)',
			), 
			'keys' => array());
	}	
	
	public function getAttendeeNameLink() {
		if ($this->contact) {
			if ($this->contact->trashed!=1) 
				return NHtml::link($this->contact->name, array('/contact/admin/view', 'id'=>$this->contact->id));
			else
				return '<span class="trashedData" title="Removed">'.$this->contact->displayName.'</span>';
		}
		else
			return $this->attendee_name;
	}
	
	public function getContactProfileImage($type='grid-thumbnail') {
		if ($this->contact)
			return $this->contact->getPhoto($type.'-'.strtolower($this->contact->contact_type));
		else
			return '<img src="'.Yii::app()->image->url(0,$type).'" />';
	}
		
}