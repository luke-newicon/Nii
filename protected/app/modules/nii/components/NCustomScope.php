<?php

class NCustomScope extends CFormModel
{
	public $rule;
	public $operator;
	
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
	
	public $defaultSearchMethod = 'eq';
	
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
	
}