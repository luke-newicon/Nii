<?php

/**
 * Description of Donations
 *
 * @author robinwilliams
 */
class HftDonation extends NActiveRecord 
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
		return 'hft_donation';
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'donation_amount' => 'Amount',
				'date_received' => "Date Rec'd",
				'contact_id' => 'Donor',
				'giftaid' => "Gift Aid?",
				'type_id' => 'Donation Type',
				'event_id' => 'Linked Event',
				'comment' => 'Comments',
				'statement_number' => 'Bank Statement #',
				'statement_date' => 'Bank Statement Date',
		);
	}
	
	public function relations() {
		return array(
			'contact'=>array(self::BELONGS_TO, 'HftContact', 'contact_id'),
			'type'=>array(self::BELONGS_TO, 'HftDonationType', 'type_id'),
		);
	}
	
	public function rules() {
		return array(
			array('donation_amount, giftaid, date_received', 'required'),
			array('type_id, event_id, comment, statement_number, statement_date', 'safe'),
			array('donation_amount, giftaid, date_received, type_id, event_id, comment, statement_number, statement_date', 'safe','on'=>'search'),
		);
	}
	
/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->getDbCriteria();
		
		$criteria->compare('id',$this->id);
		$criteria->compare('contact.name',$this->contact_id, true);
		$criteria->compare('date_received',$this->date_received,true);
		$criteria->compare('donation_amount',$this->donation_amount,true);
		$criteria->compare('giftaid',$this->giftaid);
		$criteria->compare('type_id',$this->type_id,true);
//		$criteria->compare('event.name',$this->type_id,true);
		$criteria->compare('statement_number',$this->statement_number,true);
		$criteria->compare('statement_date',$this->statement_date,true);

		$criteria->with = array('contact', 'type');
		$criteria->together = true;
		
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
				'name' => 'date_received',
				'type' => 'raw',
				'value' => 'NHtml::formatDate($data->date_received, "d-m-Y")',
				'htmlOptions'=>array('width'=>'80px'),
			),
			array(
				'name' => 'contact_id',
				'type' => 'raw',
				'value' => '$data->getContactLink(null, false)',
			),
			array(
				'name' => 'donation_amount',
				'type' => 'raw',
				'value' => '$data->displayAmount',
			),
			array(
				'name' => 'giftaid',
				'type' => 'raw',
				'value' => 'NHtml::formatBool($data->giftaid)',
				'htmlOptions'=>array('width'=>'70px'),
				'filter' => array('1'=>'Yes', '0'=>'No'),
			),
			array(
				'name' => 'type_id',
				'type' => 'raw',
				'value' => '$data->displayType',
				'htmlOptions'=>array('width'=>'100px'),
				'filter'=> HftDonationType::getTypesArray(),
			),
			array(
				'name' => 'event_id',
				'type' => 'raw',
				'value' => '$data->displayEvent',
			),
			array(
				'name' => 'statement_number',
			),
			array(
				'name' => 'statement_date',
				'type' => 'raw',
				'value' => 'NHtml::formatDate($data->statement_date, "d-m-Y")',
			),
		);
	}
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'contact_id' => 'int(11)',
				'donation_amount' => 'float',
				'date_received' => "datetime",
				'giftaid' => "int(1)",
				'type_id' => 'int(11)',
				'event_id' => 'int(11)',
				'comment' => 'text',
				'statement_number' => 'int(11)',
				'statement_date' => 'date',
				'trashed' => "int(1) unsigned NOT NULL",
			), 
			'keys' => array());
	}	
	
	
	public function getContactLink($tab=null, $showIcon=false) {
		if ($this->contact) {
			$type = "grid-thumbnail-".strtolower($this->contact->contact_type);
			$label = $showIcon ? $this->getPhoto($type) . '<span>'.$this->contact->displayName.'</span>' : $this->contact->displayName;
			if ($tab)
				return CHtml::link($label, array("/contact/admin/view","id"=>$this->contact->id, 'selectedTab'=>$tab),array('class'=>'grid-thumb-label'));
			else
				return CHtml::link($label, array("/contact/admin/view","id"=>$this->contact->id),array('class'=>'grid-thumb-label'));
		} else
			return '<span class="noData">No contact assigned</span>';
	}
	
	public function getDisplayAmount() {
		return NHtml::formatPrice($this->donation_amount);
	}
	
	public function getDisplayType() {
		if ($this->type)
			return $this->type->name;
	}
	
	public function getDisplayEvent() {
		// @todo Link to HftEvent model
		return null;
	}
}