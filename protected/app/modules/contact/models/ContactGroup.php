<?php

class ContactGroup extends NActiveRecord {
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '{{contact_group}}';
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Key',
			'label' => 'Name',
			'description' => 'Description',
			'rules' => 'Rules',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {

		$criteria = $this->getDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('rules', $this->rules, true);

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
			'name',
			'description',
			'rules',
		);
	}


	public function schema() {
		return array(
			'columns' => array(
				'id' => "pk",
				'name' => "varchar(255)",
				'label' => "varchar(255)",
				'description' => "text",
				'rules' => "text",
			),
			'keys' => array());
	}
	
}