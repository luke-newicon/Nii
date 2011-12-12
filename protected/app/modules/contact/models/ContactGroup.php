<?php

class ContactGroup extends NActiveRecord 
{
	
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
		return '{{contact_group}}';
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'rules' => 'Rules',
			'editLink' => 'Edit',
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
			array(
				'name'=>'name',
			),
			array(
				'name'=>'description',
				'type' => 'html',
			),
			array(
				'name'=>'rules',
			),
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
				'name' => "varchar(255)",
				'description' => "text",
				'rules' => "text",
			),
			'keys' => array());
	}
	
	public function getGroups() {
		// @todo: Create getGroups function
	}
	
	/**
	 *	Search groups based on a term and return a ContactGroup model, if there are results
	 * @param string $term
	 * @return model ContactGroup 
	 */
	public static function searchGroups($term) {
		return ContactGroup::model()->findAll(
			array(
				'condition'=>"name LIKE '%".$term."%'",
				'limit'=>30,
			)
		);
	}
	
	public static function getGroup($id) {
		$group = self::model()->findByPk($id);
		if ($group) {
			return array(
				'id'=>'g_'.$id,
				'name'=>$group->name,
			);
		}
	}
	
	public function getGroupContacts() {
		// @todo: Create getGroupContacts function
	}
	
	public function countGroupContacts() {
		// @todo: Create countGroupContacts function
	}
	
	
	public function getEditLink() {
		if ($this->id)
			return NHtml::link('Edit', array('edit', 'id'=>$this->id));
	}
}