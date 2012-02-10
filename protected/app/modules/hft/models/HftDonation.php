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
			'thankyou_sent' => 'Thankyou Sent',
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
			array('type_id, event_id, comment, statement_number, statement_date, contact_id, thankyou_sent', 'safe'),
			array('donation_amount, giftaid, date_received, type_id, event_id, comment, statement_number, statement_date, contact_id,
				date_received_from, date_received_to, statement_date_from, statement_date_to, thankyou_sent', 'safe','on'=>'search'),
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
		$criteria->compare('donation_amount',$this->donation_amount,true);
		$criteria->compare('giftaid',$this->giftaid);
		$criteria->compare('type_id',$this->type_id,true);
		$criteria->compare('thankyou_sent',$this->thankyou_sent);
		$criteria->compare('statement_number',$this->statement_number,true);
		
		// Add date filters
		$this->dateRangeCriteria($criteria,'date_received');
		$this->dateRangeCriteria($criteria,'statement_date');

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
				'exportValue' => 'NHtml::formatDate($data->date_received, "d-m-Y",false)',
				'header' => 'Date Rec\'d',
//				'filter' => NGridView::filterDateRange($this, 'date_received'),
				'class'=>'NDateColumn',
				'htmlOptions'=>array('width'=>'80px'),
			),
			array(
				'name' => 'contact_id',
				'type' => 'raw',
				'value' => '$data->getContactLink(null, false)',
				'exportValue' => '$data->contactName',
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
				'name' => 'thankyou_sent',
				'header' => 'Thankyou',
				'type' => 'raw',
				'value' => '$data->thankyouLink',
				'htmlOptions'=>array('width'=>'70px'),
				'filter' => array('1'=>'Sent', '0'=>'Not sent'),
			),
			array(
				'name' => 'event_id',
				'type' => 'raw',
				'value' => '$data->eventLink',
				'exportValue' => '$data->eventName',
			),
//			array(
//				'name' => 'statement_number',
//			),
//			array(
//				'name' => 'statement_date',
//				'type' => 'raw',
//				'value' => 'NHtml::formatDate($data->statement_date, "d-m-Y")',
//				'exportValue' => 'NHtml::formatDate($data->statement_date, "d-m-Y","-")',
////				'filter' => NGridView::filterDateRange($this, 'statement_date'),
//				'class'=>'NDateColumn',
//				'htmlOptions'=>array('width'=>'120px'),
//			),
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
				'contact_id' => 'int(11)',
				'donation_amount' => 'float',
				'date_received' => "datetime",
				'giftaid' => "int(1)",
				'type_id' => 'int(11)',
				'event_id' => 'int(11)',
				'comment' => 'text',
				'statement_number' => 'int(11)',
				'statement_date' => 'date',
				'thankyou_sent' => "int(1) NOT NULL",
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
			$label = $showIcon ? $this->contact->getPhoto($type) . '<span>'.$this->contact->displayName.'</span>' : $this->contact->displayName;
			if ($this->contact->trashed==0) {
				if ($tab)
					return CHtml::link($label, array("/contact/admin/view","id"=>$this->contact->id, 'selectedTab'=>$tab),array('class'=>'grid-thumb-label'));
				else
					return CHtml::link($label, array("/contact/admin/view","id"=>$this->contact->id),array('class'=>'grid-thumb-label'));
			} else {
				return '<span class="trashedData grid-thumb-label" title="Removed">'.$label.'</span>';
			}
		} else
			return '<span class="noData">No contact assigned</span>';
	}
	
	public function getContactName($echoNoData=false) {
		if ($this->contact) {
			if ($this->contact->trashed==0)
				return $this->contact->displayName;
			else
				return '<span class="trashedData" title="Removed">'.$this->contact->displayName.'</span>';
		}
		elseif ($echoNoData!=false)
			return '<span class="noData">No contact assigned</span>';
	}
	
	public function getDisplayAmount() {
		return NHtml::formatPrice($this->donation_amount);
	}
	
	public function getDonationIdLink() {
		return NHtml::link($this->id, array('/hft/donation/view', 'id'=>$this->id));
	}
	
	public function getDonationAmountLink() {
		return NHtml::link($this->displayAmount, array('/hft/donation/view', 'id'=>$this->id));
	}
	
	public function getDonationDateLink() {
		return NHtml::link(NHtml::formatDate($this->date_received, "d-m-Y"), array('/hft/donation/view', 'id'=>$this->id));
	}
	
	public function getEditLink() {
		if ($this->id)
			return NHtml::link('Edit', array('/hft/donation/edit', 'id'=>$this->id));
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
			return $this->event->name . ($this->event->trashed==1 ? ' (removed)' : '');
		else {
			if ($echoNoData!=false)
				return '<span class="noData">No event assigned</span>';
		}
	}
	
	
	public function getEventLink($tab=null) {
		if ($this->event) {
			$label = $this->event->name;
			if ($this->event->trashed==0) {
				if ($tab)
					return CHtml::link($label, array("/hft/event/view","id"=>$this->event->id, 'selectedTab'=>$tab));
				else
					return CHtml::link($label, array("/hft/event/view","id"=>$this->event->id));
			} else {
				return '<span class="trashedData" title="Removed">'.$label.'</span>';
			}
		} else
			return '<span class="noData">No event assigned</span>';
	}
	
	public function getThankyouLink($ajax=true) {
		if ($this->thankyou_sent==1)
			return '<span class="icon fam-accept">&nbsp;</span>Sent';
		
		$message = 'Are you sure you want to mark thankyou as sent?';
		
		if ($ajax)
			return NHtml::confirmAjaxLink('Send Now', array('/hft/donation/thankyouSent','id'=>$this->id), $message, 'DonationAllGrid', array('style'=>'color: #900;'));
		else
			return NHtml::confirmLink('<span class="icon fam-delete">&nbsp;</span>Send Now', array('/hft/donation/thankyouSent','id'=>$this->id), $message);
	}
	
	public static function countRecentDonors() {
		return self::model()->count('date_received >= :date GROUP BY contact_id',array(':date' => date('Y-m-d',strtotime('- 2 weeks'))));
	}
	
	public static function countMajorDonors() {
		return self::model()->count('donation_amount >= :amount GROUP BY contact_id',array(':amount' => 2000));
	}
	
	
	/**
	 *	Array of rule fields, to be used in contact group rules
	 * @return array - assoc. array of grouped fields. See Contacts group below as an example
	 */
	public static function groupRuleFields() {
		return array(
			'Donations' => array(
				'model' => __CLASS__,
				'fields' => array(
					'date_received' => array(
						'label' => 'Date Received',
						'type' => 'date',
					),
					'donation_amount' => array(
						'label' => 'Donation Amount',
					),
					'giftaid' => array(
						'label' => 'Gift Aid?',
						'type' => 'bool',
					),
					'type_id' => array(
						'label' => 'Donation Type',
						'type' => 'select',
						'filter' => HftDonationType::getTypesArray(),
					),
					'thankyou_sent' => array(
						'label' => 'Thankyou Sent?',
						'type' => 'bool',
					),
				),
			)
		);
	}	
	
	public function scopes() {
		return array(
			'thankyou_sent' => array(
				'condition' => 'thankyou_sent = 1 AND t.trashed <> 1',
			),
			'thankyou_not_sent' => array(
				'condition' => 'thankyou_sent = 0 AND t.trashed <> 1',
			),
		);
	}
	
	public function getGridScopes() {
		$scopes = array(
			'items'=>array(
				'default' => array(
					'label'=>'All',
				),
				'thankyou_sent' => array(
					'label'=>'Thanked',
					'description'=>'Donations for which a thankyou letter or email HAS been sent',
				),
				'thankyou_not_sent' => array(
					'label'=>'Not Thanked',
					'description'=>'Donations for which a thankyou letter or email HAS NOT been sent',
				),
			)
		);
		return $scopes;
	}

	
}