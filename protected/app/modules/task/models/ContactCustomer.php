<?php

class ContactCustomer extends Contact {
	
	public $gridView = '//task/admin/customers';

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
		return '{{contact_customer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'contact' => array(self::BELONGS_TO, 'Contact', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria = $this->getDbCriteria();

		$criteria->compare('id', $this->id);

		return new NActiveDataProvider($this,
			array(
				'criteria' => $criteria,
			)
		);
	}
	
	public function columns() {
		return array(
			array(
				'name' => 'id',
			),
			array(
				'name' => 'contact.name',
			),
		);
	}

	public static function install($className=__CLASS__) {
		parent::install($className);
	}

	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
			),
			'keys' => array()
		);
	}

}