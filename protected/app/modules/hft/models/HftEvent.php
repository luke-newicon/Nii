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
		);
	}
	
	public function relations() {
		return array(
//			'attendees'=>array(self::HAS_MANY, 'HftAttendees', 'event_id'),
		);
	}
	
	public function rules() {
		return array(
			array('name, start_date', 'required'),
			array('end_date, organiser_type, organiser_name, description', 'safe'),
			array('name, start_date, end_date, organiser_type, organiser_name, description', 'safe','on'=>'search'),
		);
	}
	
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
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('organiser_type_id',$this->organiser_type_id);
		$criteria->compare('organiser_name',$this->organiser_name,true);

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
			),
			array(
				'name' => 'start_date',
				'type' => 'raw',
				'value' => 'NHtml::formatDate($data->start_date, "d-m-Y")',
				'htmlOptions'=>array('width'=>'80px'),
			),
			array(
				'name' => 'end_date',
				'type' => 'raw',
				'value' => 'NHtml::formatDate($data->end_date, "d-m-Y")',
				'htmlOptions'=>array('width'=>'80px'),
			),
			array(
				'name' => 'organiser_type_id',
				'type' => 'raw',
				'value' => '$data->displayOrganiserType',
				'htmlOptions'=>array('width'=>'100px'),
				'filter'=> HftEventOrganiserType::getTypesArray(),
			),
			array(
				'name' => 'organiser_name',
			),
			array(
				'name' => 'statement_number',
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
	
		
	public function getDisplayEvent() {
		// @todo Link to HftEvent model
		return null;
	}
}