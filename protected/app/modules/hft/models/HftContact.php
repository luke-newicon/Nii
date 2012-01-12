<?php

/**
 * Description of HftContact
 *
 * @author robinwilliams
 */
class HftContact extends Contact
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = Contact::model()->attributeLabels();
		return array_merge($labels, 
			array(
				'source_id' => 'Source',
				'id' => 'Account Number',
				'receive_letters' => 'Letter',
				'receive_emails' => 'Email',
			)
		);
	}
	
	public function relations() {
		$relations = Contact::model()->relations();
		return array_merge($relations, array(
			'source'=>array(self::BELONGS_TO, 'HftContactSource', 'source_id'),
			'donation'=>array(self::HAS_MANY, 'HftDonation', 'contact_id'),
		));
	}
	
	public function rules() {
		$rules = Contact::model()->rules();
		return array_merge($rules, array(
			array('account_number, source_id, newsletter, receive_letters, receive_emails, status', 'safe'),
			array('account_number, source_id, newsletter, receive_letters, receive_emails, status', 'safe','on'=>'search'),
		));
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
		
		$this->getSearchCriteria($criteria);
		
		$criteria->compare('status', $this->status);
		$criteria->compare('receive_letters', $this->receive_letters);
		$criteria->compare('receive_emails', $this->receive_emails);

		$criteria->with = array('donation');
		$criteria->together = true;
		
		$sort = new CSort;
		$sort->defaultOrder = 't.id DESC';		
		
		return new NActiveDataProvider($this, array(
			'criteria'=>$criteria,	
			'sort' => $sort,
			'pagination'=>array(
				'pageSize'=>20,
            ),
		));
	}
	
	public function columns() {
		
		$columns = Contact::model()->columns();
		return array_merge(
			array(
				array(
					'name' => 'id',
					'header' => 'Acc. #',
					'htmlOptions'=>array('width'=>'60px'),
				),
			),
			$columns, 
			array(
				array(
					'name' => 'countDonations',
					'header'=>'Donations',
					'type'=>'raw',
					'exportValue'=>'$data->getCountDonations(false)',
					'htmlOptions'=>array('width'=>'60px','style'=>'text-align:center'),
				),
				array(
					'name' => 'source_id',
					'type' => 'raw',
					'value' => '$data->sourceName',
					'filter'=> HftContactSource::getSourcesArray(),
				),
				array(
					'name' => 'status',
					'type' => 'raw',
					'value' => '$data->status',
					'filter'=> NHtml::enumItem($this, 'status'),
					'htmlOptions'=>array('width'=>'60px'),
				),
				array(
					'name' => 'receive_letters',
					'type' => 'raw',
					'value' => 'NHtml::formatBool($data->receive_letters)',
					'filter'=> array('1'=>'Yes','0'=>'No'),
					'sortable' => false,
				),
				array(
					'name' => 'receive_emails',
					'type' => 'raw',
					'value' => 'NHtml::formatBool($data->receive_emails)',
					'filter'=> array('1'=>'Yes','0'=>'No'),
					'sortable' => false,
				),
			)
		);
	}
	
	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'title' => "enum('Mr','Mrs','Ms','Miss','Dr','Prof','Revd','Revd Dr','Revd Prof','Revd Canon','Most Revd','Rt Revd','Rt Revd Dr','Venerable','Revd Preb','Pastor','Sister')",
				'lastname' => "varchar(255)",
				'salutation' => "varchar(255)",
				'givennames' => "varchar(255)",
				'dob' => "date",
				'gender' => "enum('M','F')",
				'email' => "varchar(75)",
				'addr1' => "varchar(100)",
				'addr2' => "varchar(100)",
				'addr3' => "varchar(100)",
				'city' => "varchar(50)",
				'county' => "varchar(50)",
				'country' => "varchar(50)",
				'postcode' => "varchar(20)",
				'tel_primary' => "varchar(50)",
				'mobile' => "varchar(50)",
				'tel_secondary' => "varchar(50)",
				'fax' => "varchar(50)",
				'website' => "varchar(255)",
				'comment' => "text",
				'company_name' => "varchar(255)",
				'contact_name' => "varchar(255)",
				'name' => "varchar(255) NOT NULL",
				'contact_type' => "enum('Person','Organisation')",
				'source_id' => 'int(11)',
				'receive_letters' => 'int(1) unsigned NOT NULL DEFAULT 1',
				'receive_emails' => 'int(1) unsigned NOT NULL DEFAULT 1',
				'account_number' => 'varchar(30)',
				'status' => "enum('Active','Archived','Deceased') DEFAULT 'Active'",
				'trashed' => "int(1) unsigned NOT NULL",
			), 
			'keys' => array());
	}
	
	public function getSourceName() {
		if ($this->source)
			return $this->source->name;
	}
	
	public function getDonations() {
		$donations = HftDonation::model()->findAllByAttributes(array('contact_id'=>$this->id));
		if($donations)
			return $donations;
		else
			return false;
	}
	
	public function getCountDonations($displayEmpty=true) {
		if ($this->id) {
			$donations = HftDonation::model()->countByAttributes(array('contact_id'=>$this->id));
			if($donations)
				return $donations;
			else if ($displayEmpty)
				return '<span class="noData">---</span>';
		}
	}
	
	/**
	 *	Tabs top - return array of items to include at the top of the contact view 'tabs' section
	 * @return array 
	 */
	public function getArrayTabsTop() {
		$return = array();
		if ($this->donations !=false)
			$return = array(
				'Donations'=>array('ajax'=>array('/hft/donation/contactDonations','id'=>$this->id), 'id'=>'donations', 'count'=>$this->countDonations)
			);
		return $return;
	}
	
	/**
	 *	Tabs top - return array of items to include at the bottom of the contact view 'tabs' section
	 * @return array 
	 */	
	public function getArrayTabsBottom() {
		return array();
	}
	
	public function scopes() {
		return array_merge(parent::scopes(), array(
			'donors' => array(
				'condition' => 'donation.id > 0 AND t.trashed <> 1',
				'with' =>'donation',
			),
			'newsletter' => array(
				'condition' => 'newsletter = 1 AND t.trashed <> 1',
			),
			'active' => array(
				'condition' => 't.`status` = "Active" AND t.trashed <> 1',
			),
			'all' => array(
				'condition' => 't.trashed <> 1',
			)
		));
	}
	
	public function newsletterRecipients() {
		
		return new CDbCriteria(
			array('condition'=>'t.receive_emails = "1"')
		);
	}
	
	public function getGridScopes() {
		$scopes = array_merge_recursive(parent::getGridScopes(), array(
			'default' => 'active',
			'items'=>array(
				'active' => array(
					'label'=>'Active',
				),
				'all' => array(
					'label'=>'All',
					'description'=>'All contacts in the system, including those hidden by default',
				),
				'emails' => array(
					'label'=>'Emails',
					'description'=>'All contacts with a valid email address',
				),
				'donors' => array(
					'label'=>'Donors',
					'description'=>'Contacts that have made a donation in the past',
				),	
				'newsletter' => array(
					'label'=>'Newsletter',
					'description'=>'Contacts who are willing to receive the newsletter',
				),
			)
		));
		unset($scopes['items']['default']);
		return $scopes;
	}
	
}