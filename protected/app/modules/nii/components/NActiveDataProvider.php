<?php

class NActiveDataProvider extends CActiveDataProvider {

	/**
	 * @var string Get parameter name for current selected scopes
	 */
	public $scopeVar = 'scope';
	public $filterVar = 'filter';

	/**
	 *
	 * @var bool Flag that the scopes/filter have been added
	 */
	private $_scopesAdded = false;
	private $_filterAdded = false;
	
	public $defaultScope = 'default';
	public $gridId;
	
	/**
	 * Fetches the data from the persistent data storage.
	 * @return array list of data items
	 */
	protected function fetchData() {

		$this->addScopes();

		return parent::fetchData();
	}

	private function addScopes() {
		if ($this->_scopesAdded === false) {	
			$scopes = Yii::app()->user->settings->get('custom_scope_'.$this->gridId, array());
			$customScopes = array_key_exists($this->getCurrentScope(), $scopes) ? $scopes[$this->getCurrentScope()] : null;
			if ($customScopes) {
				$this->addCustomScope($customScopes); 
			} else {
				foreach ($this->getScopes($this->getCurrentScope()) as $scope) {
					try {
						$this->model->{$scope}();
					} catch (Exception $e) {
						
					}
				}
			}
			$this->_scopesAdded = true;
		}
	}

	public function getCurrentScope() {
		if (isset($_GET[$this->scopeVar]))
			$scope = $_GET[$this->scopeVar];
		else
			$scope = $this->defaultScope;
		return $scope;
	}

	public function getScopes($scope) {
		if ($scope && $scope != 'default')
			return explode('.', $scope);
		else
			return array();
	}
	
	public function addCustomScope($customScopes) {
		$criteria = $this->model->getDbCriteria();
		$value = $customScopes;
		foreach ($value['rule'] as $rule) {
			$customScope = new NCustomScope($rule, $value['match']);
			$customScope->getCondition($criteria, $value['formModel']);
		}
	}

	public function countScope($scope) {
		$this->model->setDbCriteria(null);
		foreach ($this->getScopes($scope) as $scope)
			$this->model->{$scope}();
		return $this->model->count();
	}
	
	public function countCustomScope($customScopes) {
		$value = $customScopes;
		
		$this->model->setDbCriteria(null);
		
		$criteria = $this->model->getDbCriteria();

		$criteria->with = $this->criteria->with;
		$criteria->together = $this->criteria->together;
		

		
		foreach ($value['rule'] as $rule) {
			$customScope = new NCustomScope($rule, $value['match']);
			$customScope->getCondition($criteria, $value['formModel']);
		}
		return $this->model->count();
	}	
}