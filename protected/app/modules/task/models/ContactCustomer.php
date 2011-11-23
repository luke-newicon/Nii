<?php

class ContactCustomer extends ContactRelation {

//	public $gridView = '//task/admin/customers';
	
	public $label = 'Customer';

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
			'contact' => array(self::BELONGS_TO, 'Contact', 'contact_id'),
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
				'name' => 'contact_name',
				'type' => 'raw',
				'value' => '$data->getContactLink(\'Customer\')',
			),
		);
	}
	
	public function getAddUrl(){
		return array('/contact/customer/add', 'id' => $this->id());
	}
	
	public function getViewUrl(){
		return array('/contact/customer/view', 'id' => $this->id());
	}
	
	public function getEditUrl(){
		return array('/contact/customer/edit', 'id' => $this->id());
	}

	public function viewLink($text=null) {
		if ($this->contact) {
			if (!$text)
				$text = $this->contact->name;
			return CHtml::link($text, $this->viewUrl);
		}
	}

	public static function install($className=__CLASS__) {
		parent::install($className);
	}

	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'contact_id' => 'int',
			),
			'keys' => array()
		);
	}
	
	public function getName(){
		if($this->contact)
			return $this->contact->name; 
	}
	
	public static function customerList(){
		return CHtml::listData(self::model()->findAll(), 'id', 'name');
	}

}