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
			'filterScopes' => 'Rules',
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
		$criteria->compare('filterScopes', $this->filterScopes, true);

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
				'type' => 'raw',
				'value' => '$data->viewLink',
				'exportValue' => '$data->name',
			),
			array(
				'name'=>'description',
				'type' => 'html',
			),
			array(
				'name'=>'filterScopes',
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
				'filterScopes' => "text",
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
	
	/**
	 *	Get contacts for a specific group. Returns contact IDs
	 * @return array - contact IDs 
	 */
	public function getGroupContacts() {
		// @todo: Finish getGroupContacts function
		
		$contacts = array();
		// First: get contacts from ContactGroupContact
		$cgcs = NActiveRecord::model('ContactGroupContact')->findAllByAttributes(array('group_id'=>$this->id));
		foreach ($cgcs as $cgc)
			$contacts[$cgc->contact_id] = $cgc->contact->name;
		
		// Next: get contacts from dynamic scopes on the model - trickier...
		if ($this->filterScopes) {
			$fs = CJSON::decode($this->filterScopes);
			if (isset($fs)){
				
			} else {
				$contactModel  = Yii::app()->getModule('contact')->contactModel;
				$criteria = NActiveRecord::model($contactModel)->{$this->filterScopes}();
				$c = NActiveRecord::model($contactModel)->findAll($criteria);
				foreach ($c as $value)
					$contacts[$value->id] = $value->name;
			}
		}
		// Last: return contacts
		return $contacts;
	}
	
	/**
	 *	Gets contacts for the group and returns them as a comma-separated list
	 * @return string
	 */
	public function getGroupContactsList() {
		$contacts = $this->groupContacts;
		if ($contacts)
			return implode(',',$contacts);
	}
	
	/**
	 *	Gets contacts, makes them into links and returns them as a list
	 * @return string 
	 */
	
	public function getGroupContactsLinks() {
		$contacts = $this->groupContacts;
		if ($contacts) {
			foreach ($contacts as $k =>$contact)
				$c[] = NHtml::link($contact, array('/contact/admin/view', 'id'=>$k));
			return implode('; ',$c);
		}
	}
	
	/**
	 *	Return a count of the contacts in a group
	 * @return int 
	 */
	public function countGroupContacts() {
		return count($this->groupContacts);
	}
	
	/**
	 *	Return the edit link for a group
	 * @return string 
	 */
	public function getEditLink() {
		if ($this->id)
			return NHtml::link('Edit', array('edit', 'id'=>$this->id));
	}
	
	/**
	 *	Return the edit link for a group
	 * @return string 
	 */
	public function getViewLink() {
		if ($this->id)
			return NHtml::link($this->name, array('view', 'id'=>$this->id));
	}
}