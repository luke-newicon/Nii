<?php

class ContactGroupContact extends NActiveRecord 
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
		return '{{contact_group_contact}}';
	}
	
	public function relations() {
		return array(
			'contact'=>array(self::BELONGS_TO, 'HftContact', 'contact_id'),
			'group'=>array(self::BELONGS_TO, 'ContactGroup', 'group_id'),
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return NActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id=null) {

		$criteria = $this->getDbCriteria();

		$criteria->compare('id', $this->id);
		$criteria->compare('contact.name', $this->contact_name, true);
		$criteria->compare('contact.email', $this->email, true);
		
		if (isset($id))
			$criteria->compare('group_id', $id);

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
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'contact_id' => 'Contact',
			'group_id' => 'Group',
			'contact_name' => 'Contact Name',
		);
	}
	
	
	public function columns() {
		return array(
			array(
				'name'=>'contact_name',
				'type' => 'raw',
				'value' => '$data->contactLink',
				'exportValue' => '$data->contactName',
			),
			array(
				'name'=>'email',
				'type' => 'raw',
				'value' => '$data->contactEmailLink',
				'exportValue' => '$data->contactEmail',
			),
		);
	}


	public function schema() {
		return array(
			'columns' => array(
				'id' => 'pk',
				'contact_id' => "int(11)",
				'group_id' => "int(11)",
			),
			'keys' => array());
	}
	
	public $contact_name, $email;
	
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
	
	public function getContactEmailLink() {
		if ($this->contact)
			return $this->contact->emailLink;
	}
	
	public function getContactEmail() {
		if ($this->contact)
			return $this->contact->email;
	}
	
}