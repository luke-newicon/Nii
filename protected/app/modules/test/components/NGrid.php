<?php

class NGrid extends CModel {

	public $_attributes;
	public $_models;

	public function models() {
		return array();
	}
	
	public function model(){
		return array_shift(array_keys($this->models()));
	}

	public function search() {
		return new NActiveDataProvider($this->model());
	}

	public function attributeNames() {
		return array_keys($this->_attributes);
	}

}