<?php

class ContactGroupRule extends CFormModel
{
	public $rule, $ruleGroup, $operator;
	
	public function __construct($rule=null, $operator=null) {
		if ($rule)
			$this->rule = $rule;
		if ($operator)
			$this->operator = $operator;
	}
	
	public $searchMethods = array(
		'=' => array(
			'label' => 'is',
			'value' => '=', 
			'useForDropdown' => true
		),
		'<' => array(
			'label' => '<', 
			'value' => '<', 
			'useForDropdown' => false
		),
		'>' => array(
			'label' => '>', 
			'value' => '>', 
			'useForDropdown' => false
		),
		'<=' => array(
			'label' => '<=', 
			'value' => '<=', 
			'useForDropdown' => false
		),
		'>=' => array(
			'label' => '>=', 
			'value' => '>=', 
			'useForDropdown' => false
		),
		'<>' => array(
			'label' => 'is not', 
			'value' => '<>', 
			'useForDropdown' => true
		),
		'contains' => array(
			'label' => 'contains', 
			'value' => '', 
			'useForDropdown' => false
		),
	);
	
	public $defaultSearchMethod = 'is';
	
	public function getCondition(&$criteria, $model=null) {
		$searchMethod = $this->rule['searchMethod'] ? $this->rule['searchMethod'] : 'contains';
		$sm = $this->searchMethods[$searchMethod]['value'];
		if ($model) {
			$model = new $model;
			try {
				if($model->translateCustomScopes($this->rule['field'], $this->rule['value'], $sm, $this->operator, $criteria)!==false)
					return;
			} catch (Exception $e) {
				
			}
		}
		$criteria->compare($this->rule['field'], $sm.$this->rule['value'], true, $this->operator);
	}
	
	public function getRuleFields($grouping=null) {
		return Yii::app()->getModule('contact')->getGroupRuleFields($grouping);
	}
	
	public function getRuleFieldsDropdown($grouping=null) {
		return Yii::app()->getModule('contact')->getGroupRuleFieldsArray($grouping);
	}	
	
	public function getSearchOperators($grouping, $field) {
		$fields = $this->getRuleFields($grouping);
		switch($fields['fields'][$field]['type']) {
			
			case "bool":
			case "select" :
				foreach ($this->searchMethods as $method) {
					if ($method['useForDropdown']!=null)
						$methods[$method['value']] = $method['label'];
				}
				break;
				
			default :
				foreach ($this->searchMethods as $method)
					$methods[$method['value']] = $method['label'];
		}
		return $methods;
	}

	public function drawSearchBox($grouping, $field) {
		$fields = $this->getRuleFields($grouping);
		switch(@$fields['fields'][$field]['type']) {
			
		}
	}
}