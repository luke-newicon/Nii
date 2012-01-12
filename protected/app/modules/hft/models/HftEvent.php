<?php

/**
 * Description of HftEvents
 *
 * @author robinwilliams
 */
class HftEvent extends NActiveRecord 
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
		return 'hft_event';
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Event Name',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'organiser_type_id' => 'Organiser Type',
			'organiser_name' => 'Organiser\'s Name',
			'description' => 'Description of the Event',
			'editLink' => 'Edit',
			'emailLink' => 'Email',
			'totalAttendees' => 'Attendees'
		);
	}
	
	public function relations() {
		return array(
			'attendees'=>array(self::HAS_MANY, 'HftEventAttendee', 'event_id'),
			'org_type'=>array(self::BELONGS_TO, 'HftEventOrganiserType', 'organiser_type_id'),
		);
	}
	
	public function rules() {
		return array(
			array('name, start_date', 'required'),
			array('end_date, organiser_type_id, organiser_name, description', 'safe'),
			array('name, start_date, end_date, organiser_type_id, organiser_name, description, start_date_from, start_date_to, end_date_from, end_date_to', 'safe','on'=>'search'),
		);
	}
	
	public $start_date_from, $start_date_to, $end_date_from, $end_date_to;
	
/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search(){
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->getDbCriteria();
		
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name, true);
//		$criteria->compare('start_date',$this->start_date,true);
//		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('organiser_type_id',$this->organiser_type_id);
		$criteria->compare('organiser_name',$this->organiser_name,true);
		
		// Add date filters
		$this->dateRangeCriteria($criteria,'start_date');
		$this->dateRangeCriteria($criteria,'end_date');

		return new NActiveDataProvider($this, array(
			'criteria'=>$criteria,	
			'pagination'=>array(
				'pageSize'=>30,
            ),
		));
	}
	
	public function columns() {
		
		return array(
			array(
				'name' => 'name',
				'type' => 'raw',
				'value' => '$data->nameLink',
			),
			array(
				'name' => 'start_date',
				'type' => 'raw',
				'value' => 'NHtml::formatDate($data->start_date, "d-m-Y")',
				'exportValue' => 'NHtml::formatDate($data->start_date, "d-m-Y",false)',
				'htmlOptions'=>array('width'=>'80px'),
//				'filter' => NGridView::filterDateRange($this, 'start_date'),
				'class'=>'NDateColumn',
			),
			array(
				'name' => 'end_date',
				'type' => 'raw',
				'value' => 'NHtml::formatDate($data->end_date, "d-m-Y")',
				'exportValue' => 'NHtml::formatDate($data->end_date, "d-m-Y",false)',
				'htmlOptions'=>array('width'=>'80px'),
//				'filter' => NGridView::filterDateRange($this, 'end_date'),
				'class'=>'NDateColumn',
			),
			array(
				'name' => 'organiser_type_id',
				'type' => 'raw',
				'value' => '$data->displayOrganiserType',
				'htmlOptions'=>array('width'=>'150px'),
				'filter'=> HftEventOrganiserType::getTypesArray(),
			),
			array(
				'name' => 'organiser_name',
			),
			array(
				'name' => 'totalAttendees',
				'sortable' => false,
				'htmlOptions'=>array('width'=>'30px'),
			),
			array(
				'name' => 'emailLink',
				'type' => 'raw',
				'value' => '$data->emailLink',
				'filter' => false,
				'sortable' => false,
				'htmlOptions'=>array('width'=>'30px'),
				'export'=>false,
			),
			array(
				'name' => 'editLink',
				'type' => 'raw',
				'value' => '$data->editLink',
				'filter' => false,
				'sortable' => false,
				'htmlOptions'=>array('width'=>'30px'),
				'export'=>false,
			),
		);
	}
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'name' => 'varchar(255)',
				'start_date' => 'date',
				'end_date' => "date",
				'organiser_type_id' => "int(11)",
				'organiser_name' => "varchar(255)",
				'description' => 'text',
				'trashed' => "int(1) unsigned NOT NULL",
			), 
			'keys' => array());
	}	
	
	function behaviors() {
		return array(
			'trash'=>array(
				'class'=>'nii.components.behaviors.ETrashBinBehavior',
				'trashFlagField'=>$this->getTableAlias(false, false).'.trashed',
			)
		);
	}
	
	public function getNameLink() {
		return NHtml::link($this->name, array('/hft/event/view', 'id'=>$this->id));
	}
	
	public function getEditLink() {
		return NHtml::link('Edit', array('/hft/event/edit', 'id'=>$this->id));
	}
	
	public function getEmailLink() {
		return NHtml::link('Email', array('emailAttendees', 'id'=>$this->id));
	}
		
	public function getDisplayEvent() {
		// @todo Link to HftEvent model
		return null;
	}
	
	public function getDisplayOrganiserType() {
		if ($this->org_type)
			return ($this->org_type->name);
	}
	
	public function getTotalAttendees() {
		$attendees = HftEventAttendee::model()->findAllByAttributes(array('event_id'=>$this->id));
		$count = 0;
		if ($attendees) {
			foreach ($attendees as $a)
				$count = $count + 1 + $a->additional_attendees;
		}
		if ($this->id)
			return $count;
	}
	
	public function countNotes() {
		$model = get_class($this);
		$model_id = $this->id;
		Yii::import('nii.widgets.notes.models.NNote');
		return NNote::countNotes($model, $model_id);
	}
	
	public function countAttachments() {
		$model = get_class($this);
		$model_id = $this->id;
		Yii::import('nii.widgets.attachments.models.NAttachment');
		return NAttachment::countAttachments($model, $model_id);
	}
	
	/**
	 *	Array of rule fields, to be used in contact group rules
	 * @return array - assoc. array of grouped fields. See Contacts group below as an example
	 */
	public static function groupRuleFields() {
		return array(
			'Events' => array(
				'model' => __CLASS__,
				'fields' => array(
					'start_date'=>array(
						'label' => 'Start Date',
						'type' => 'date',
					),
					'end_date'=>array(
						'label' => 'End Date',
						'type' => 'date',
					),
				),
			)
		);
	}		

	public function scopes() {
		return array(
			'future' => array(
				'condition' => 'end_date >= CURDATE() OR (end_date="0000-00-00" AND start_date >= CURDATE())',
			),
			'past' => array(
				'condition' => '(end_date < CURDATE() AND end_date > "0000-00-00") OR (end_date="0000-00-00" AND start_date < CURDATE())',
				'order' => 'start_date DESC',
			),
			'all' => array(
				'condition' => 't.trashed <> 1',
			),
		);
	}
	
	public function getGridScopes() {
		$scopes = array(
			'default' => 'future',
			'items'=>array(
				'future' => array(
					'label'=>'Future Events',
				),
				'past' => array(
					'label'=>'Past Events',
				),
				'all' => array(
					'label'=>'All',
					'description'=>'All events in the system',
				),
			)
		);
		return $scopes;
	}
	

	public function translateCustomScopes($field=null, $value=null, $sm=null, $op=null, &$criteria) {

		switch ($field) {
			case 'totalAttendees' :
					$criteria->addCondition('(SELECT id FROM hft_event_attendee WHERE event_id = t.id) '.$sm.' '.$value, $op);
				break;

			default :
				return false;
		}
	}
	
}