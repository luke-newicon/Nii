<?php

class UserTask extends AuthItem {
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function defaultScope(){
		return array(
			'condition' => 'type = 1',
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'operations' => array(self::MANY_MANY, 'AuthItem',
                'AuthItemChild(parent, child)'),
			'roles' => array(self::MANY_MANY, 'AuthItem',
                'AuthItemChild(child, parent)'),
		);
	}
	
	public function search($parent){
		return new NActiveDataProvider($this);
	}
	
	public function getRole($roleName){
		return Yii::app()->authManager->hasItemChild($roleName, $this->name);
	}
	
	public function displayRoleCheckbox($roleName){
		return CHtml::checkBox('Permission['.$this->name.']['.$roleName.']',$this->getRole($roleName));
	}

}