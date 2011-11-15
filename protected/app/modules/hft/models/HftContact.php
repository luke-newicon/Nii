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
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contact';
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
				'account_number' => 'Account Number',
			)
		);
	}
	
	public function relations() {
		$relations = Contact::model()->relations();
		return array_merge($relations, array(
			'source'=>array(self::BELONGS_TO, 'HftContactSource', 'source_id'),
		));
	}
	
	public function rules() {
		$rules = Contact::model()->rules();
		return array_merge($rules, array(
			array('account_number, source_id', 'safe'),
			array('account_number, source_id', 'safe','on'=>'search'),
		));
	}
	
	public function columns() {
		
		$columns = Contact::model()->columns();
		return array_merge(
			array(
				array(
					'name' => 'account_number',
					'header' => 'Acc. #',
				),
			),
			$columns, 
			array(
				array(
					'name' => 'source_id',
					'type' => 'raw',
					'value' => '$data->sourceName',
					'filter'=> HftContactSource::getSourcesArray(),
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
				'account_number' => 'varchar(30)',
				'trashed' => "int(1) unsigned NOT NULL",
			), 
			'keys' => array());
	}
	
	public function getSourceName() {
		if ($this->source)
			return $this->source->name;
	}
	
}