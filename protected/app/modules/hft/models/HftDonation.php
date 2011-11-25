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
			'date_received' => "Date Received",
			'contact_id' => 'Donor',
			'giftaid' => "Gift Aid?",
			'type_id' => 'Donation Type',
			'event_id' => 'Linked Event',
			'comment' => 'Comments',
			'statement_number' => 'Bank Statement #',
			'statement_date' => 'Bank Statement Date',
			'editLink' => 'Edit',
		);
	}
	
	public function relations() {
		return array(
			'contact'=>array(self::BELONGS_TO, 'HftContact', 'contact_id'),
			'type'=>array(self::BELONGS_TO, 'HftDonationType', 'type_id'),
			'event'=>array(self::BELONGS_TO, 'HftEvent', 'event_id'),
		);
	}
	
	public function rules() {
		return array(
			array('donation_amount, giftaid, date_received', 'required'),
			array('type_id, event_id, comment, statement_number, statement_date, contact_id', 'safe'),
			array('donation_amount, giftaid, date_received, type_id, event_id, comment, statement_number, statement_date, contact_id,
				date_received_from, date_received_to, statement_date_from, statement_date_to', 'safe','on'=>'search'),
		);
	}
	
	public $date_received_from, $date_received_to, $statement_date_from, $statement_date_to;
	
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
		
		// Add date filters
		if((isset($this->date_received_from) && trim($this->date_received_from) != "") && (isset($this->date_received_to) && trim($this->date_received_to) != ""))
			$criteria->addBetweenCondition('date_received', ''.$this->date_received_from.'', ''.$this->date_received_to.'');

		if((isset($this->statement_date_from) && trim($this->statement_date_from) != "") && (isset($this->statement_date_to) && trim($this->statement_date_to) != ""))
			$criteria->addBetweenCondition('statement_date', ''.$this->statement_date_from.'', ''.$this->statement_date_to.'');

		$criteria->with = array('contact', 'type');
		$criteria->together = true;
		
		$sort = new CSort;
		$sort->defaultOrder = 'date_received DESC';		
		
		return new NActiveDataProvider($this, array(
			'criteria'=>$criteria,	
			'sort' => $sort,
			'pagination'=>array(
				'pageSize'=>30,
            ),
		));
	}
	
	public function columns() {
		
		return array(
			array(
				'name' => 'id',
				'htmlOptions'=>array('width'=>'30px'),
				'type' => 'raw',
				'value' => '$data->donationIdLink',
			),
			array(
				'name' => 'date_received',
				'type' => 'raw',
				'value' => '$data->donationDateLink',
				'header' => 'Date Rec\'d',
				'filter' => NGridView::filterDateRange($this, 'date_received'),
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
				'value' => '$data->donationAmountLink',
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
				'value' => '$data->eventLink',
			),
			array(
				'name' => 'statement_number',
			),
			array(
				'name' => 'statement_date',
				'type' => 'raw',
				'value' => 'NHtml::formatDate($data->statement_date, "d-m-Y")',
				'filter' => NGridView::filterDateRange($this, 'statement_date'),
				'htmlOptions'=>array('width'=>'120px'),
			),
			array(
				'name' => 'editLink',
				'type' => 'raw',
				'value' => '$data->editLink',
				'filter' => false,
				'sortable' => false,
				'htmlOptions'=>array('width'=>'30px'),
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
	
	function behaviors() {
		return array(
			'trash'=>array(
				'class'=>'nii.components.behaviors.ETrashBinBehavior',
				'trashFlagField'=>$this->getTableAlias(false, false).'.trashed',
			)
		);
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
	
	public function getContactName($echoNoData=false) {
		if ($this->contact)
			return $this->contact->displayName;
		elseif ($echoNoData!=false)
			return '<span class="noData">No contact assigned</span>';
	}
	
	public function getDisplayAmount() {
		return NHtml::formatPrice($this->donation_amount);
	}
	
	public function getDonationIdLink() {
		return NHtml::link($this->id, array('view', 'id'=>$this->id));
	}
	
	public function getDonationAmountLink() {
		return NHtml::link($this->displayAmount, array('view', 'id'=>$this->id));
	}
	
	public function getDonationDateLink() {
		return NHtml::link(NHtml::formatDate($this->date_received, "d-m-Y"), array('view', 'id'=>$this->id));
	}
	
	public function getEditLink() {
		if ($this->id)
			return NHtml::link('Edit', array('edit', 'id'=>$this->id));
	}
	
	public function getDisplayType() {
		if ($this->type)
			return $this->type->name;
	}
	
	public function getDisplayEvent() {
		// @todo Link to HftEvent model
		return null;
	}
	
	public function getEventName($echoNoData=false) {
		if ($this->event)
			return $this->event->name;
		else {
			if ($echoNoData!=false)
				return '<span class="noData">No event assigned</span>';
		}
	}
	
	
	public function getEventLink($tab=null) {
		if ($this->event) {
			$label = $this->event->name;
			if ($tab)
				return CHtml::link($label, array("/hft/event/view","id"=>$this->event->id, 'selectedTab'=>$tab));
			else
				return CHtml::link($label, array("/hft/event/view","id"=>$this->event->id));
		} else
			return '<span class="noData">No event assigned</span>';
	}
	
}