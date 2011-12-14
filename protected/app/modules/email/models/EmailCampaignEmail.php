<?php

/**
 * This is the model class for table "email_campaign_email".
 *
*/
class EmailCampaignEmail extends NActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{email_campaign_email}}';
	}

	public function getModule() {
		return Yii::app()->getModule('email');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('campaign_id', 'required'),
			array('contact_id, email_address, sent_date, opened_date, sent', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
			'contact'=>array(self::BELONGS_TO, Yii::app()->getModule('contact')->contactModel, 'contact_id'),
		);

		return $relations;
	}	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'campaign_id' => 'Campaign',
			'contact_id' => 'Recipient',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id=null) {

		$criteria = $this->getDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('campaign.subject', $this->campaign_id, true);
		$criteria->compare('contact.name', $this->contact_id, true);
		
		if (isset($id))
			$criteria->compare('campaign_id', $id);

		$sort = new CSort;
		$sort->defaultOrder = 'id DESC';

		return new NActiveDataProvider($this, array(
					'criteria' => $criteria,
					'sort' => $sort,
					'pagination' => array(
						'pageSize' => 20,
					),
				));
	}

	public function columns() {
		return array(
			array(
				'name' => 'contact_id',
				'type' => 'raw',
				'value' => '$data->contactLink',
			),
			array(
				'name' => 'email_address',
				'type' => 'raw',
				'value' => '$data->emailAddressLink',
			),
			array(
				'name' => 'sent',
				'type' => 'raw',
				'value' => 'NHtml::formatBool($data->sent)',
				'htmlOptions' => array('width'=>'40px'),
			),
			array(
				'name' => 'sent_date',
				'type' => 'raw',
				'value' => 'NHtml::formatDate($data->sent_date)',
			),
			array(
				'name' => 'opened_date',
				'type' => 'raw',
				'value' => 'NHtml::formatDate($data->opened_date)',
			),
		);
	}
	
	public function getContactLink() {
		if ($this->contact)
			return $this->contact->contactLink;
		else
			return '<span class="noData">No contact assigned</span>';
	}
	
	public function getEmailAddressLink() {
		if ($this->contact)
			return $this->contact->emailLink;
		else
			return NHtml::emailLink($this->email_address);
	}

	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'campaign_id' => "int(11)",
				'contact_id' => "int(11)",
				'email_address' => "varchar(255)",
				'sent' => "tinyint(1)",
				'sent_date' => "datetime",
				'opened_date' => "datetime",
			),
			'keys' => array());
	}
	
	public static function install($className=__CLASS__){
		parent::install($className);
	}
	
}