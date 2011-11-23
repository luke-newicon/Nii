<?php

/**
 * Description of Donations
 *
 * @author robinwilliams
 */
class HftDonationContact extends HftDonation 
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
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id=null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->getDbCriteria();
		
		$criteria->compare('id',$this->id);
		$criteria->compare('date_received',$this->date_received,true);
		$criteria->compare('donation_amount',$this->donation_amount,true);
		$criteria->compare('giftaid',$this->giftaid);
		$criteria->compare('type_id',$this->type_id,true);
//		$criteria->compare('event.name',$this->type_id,true);
		$criteria->compare('statement_number',$this->statement_number,true);
		$criteria->compare('statement_date',$this->statement_date,true);

		$criteria->with = array('type');
		$criteria->together = true;
		
		if ($id)
			$criteria->compare('contact_id',$id);
		
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
//			array(
//				'name' => 'id',
//				'htmlOptions'=>array('width'=>'30px'),
//				'type' => 'raw',
//				'value' => '$data->donationIdLink',
//			),
			array(
				'name' => 'date_received',
				'type' => 'raw',
				'value' => '$data->donationDateLink',
				'header' => 'Date Rec\'d',
				'htmlOptions'=>array('width'=>'80px'),
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
			),
//			array(
//				'name' => 'editLink',
//				'type' => 'raw',
//				'value' => '$data->editLink',
//				'filter' => false,
//				'sortable' => false,
//				'htmlOptions'=>array('width'=>'30px'),
//			),
		);
	}
	
}