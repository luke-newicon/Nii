<?php

class ContactRelation extends NActiveRecord {
	
	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'contact' => array(self::BELONGS_TO, 'Contact', 'contact_id'),
		);
	}
	
	public function getLabel(){
		return get_class($this);
	}
	
	public function getContactLink($tab=null){
		if($this->contact)
			return $this->contact->getContactLink($tab);
	}
	
	public function getAddUrl(){
		return '';
	}
	
	public function getEditUrl(){
		return '';
	}
	
	public function getViewUrl(){
		return '';
	}
	
	public function getContact_name(){
		if($this->contact)
			return $this->contact->name;
	}
}