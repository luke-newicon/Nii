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
	
	public function getCondition(&$criteria, $rule) {
		$searchMethod = $rule['searchMethod'] ? $rule['searchMethod'] : 'contains';
		$sm = $this->searchMethods[$searchMethod]['value'];
		$contactModel = Yii::app()->getModule('contact')->contactModel;
		$model = new $contactModel;
		try {
			if($model->translateCustomScopes($rule['field'], $rule['value'], $sm, $this->operator, $criteria)!==false)
				return;
		} catch (Exception $e) {

		}
		$criteria->compare($rule['field'], $sm.$rule['value'], true);
	}
	
	public function getRuleFields($grouping=null) {
		return Yii::app()->getModule('contact')->getGroupRuleFields($grouping);
	}
	
	public function getRuleFieldsDropdown($grouping=null) {
		return Yii::app()->getModule('contact')->getGroupRuleFieldsArray($grouping);
	}	
	
	public function getSearchOperators($grouping, $field) {
		$fields = $this->getRuleFields($grouping);
		$type = isset($fields['fields'][$field]['type']) ? $fields['fields'][$field]['type'] : '';
		switch($type) {
			
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

	public function drawSearchBox($grouping, $field, $count, $value=null) {
		$name='rule['.$count.'][value]';
		$fields = $this->getRuleFields($grouping);
		$options = array('class'=>'ruleValue');
		switch(@$fields['fields'][$field]['type']) {
			case "bool":
				$filter = isset($fields['fields'][$field]['filter']) ? $fields['fields'][$field]['filter'] : array(1=>'Y', 0=>'N');
				return CHtml::dropDownList($name, $value, $filter, $options);
				break;
			case "select" :
				return CHtml::dropDownList($name, $value, $fields['fields'][$field]['filter'], $options);
				break;
				
			default :
				return CHtml::textField($name, $value, $options);
		}
	}
}