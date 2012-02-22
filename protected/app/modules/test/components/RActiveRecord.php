<?php

class RActiveRecord extends NActiveRecord {
	const TYPE_STRING='RAttributeTypeString';
	const TYPE_ENUM='RAttributeTypeEnum';
	const TYPE_TEXT='RAttributeTypeText';
	const TYPE_DATE='RAttributeTypeDate';
	const TYPE_TIME='RAttributeTypeTime';

	public $defaultType = self::TYPE_STRING;
	private $_definitions = array();
	
	/**
	 * This method should be overridden to declare attribute definition objects.
	 *
	 * Below is an example declaring attribute definitions:
	 * <pre>
	 * return array(
	 *     'id'=>array(self::TYPE_INT),
	 *     'name'=>array(self::TYPE_STRING),
	 *     'comment'=>array(self::TYPE_TEXT),
	 *	   'status'=>array(self::TYPE_ENUM, 'data'=>array('inactive','active','disabled')),
	 * );
	 * </pre>
	 *
	 * @return array list of attribute definitions.
	 */
	public function attributes() {
		return array();
	}

	public function getDefinition($attribute) {
		if (!isset($this->_definitions[$attribute])) {
			$definitions = $this->attributes();
			$config = isset($definitions[$attribute]) ? $definitions[$attribute] : array();
			$this->addDefinition($attribute, $config);
		}
		return $this->_definitions[$attribute];
	}

	public function addDefinition($name, $config=array()) {
		if (isset($config[0]))  // type class
			$className = array_shift($config);
		else
			$className = self::TYPE_STRING;
		$this->_definitions[$name] = new $className($name, $this, $config);
	}

	public function setAttributes($values, $safeOnly = true) {
		if (!is_array($values))
			return;
		parent::setAttributes($values, $safeOnly);

		foreach ($this->metaData->relations as $name => $relation) {
			if (isset($values[$name]) && isset($this->$name)) {
				$this->$name->attributes = $values[$name];
			}
		}
	}
	
	/**
	 * Get the model in the search scenario state. Populate with search attributes
	 * $_GET[$className];
	 * @param string $className
	 * @return NActiveRecord in scenario search
	 */
	public function searchModel()
	{
		$className = get_class($this);
		$model = new $className('search');
		$model->unsetAttributes();
		if(isset($_GET[$className]))
			$model->attributes = $_GET[$className];
		return $model;
	}

	public function search() {
		$criteria = $this->getDbCriteria();

		foreach ($this->columns() as $column) {
			if (strpos($column, '.'))
				$criteria->compare($column, CHtml::value($this, $column), true);
			else
				$criteria->compare('t.' . $column, $this->$column, true);
		}

		$with = array();
		foreach ($this->metaData->relations as $name => $relation) {
			if ($this->$name)
				$with[] = $name;
		}
		$criteria->with = $with;
		$criteria->together = true;

		$sort = new NSort;
		$sort->model = $this;
		return new NActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => $sort,
		));
	}

}

class RBaseAttributeType extends CComponent {

	public $name;
	public $filter;
	public $export;
	public $model;

	public function __construct($name, $model, $config=array()) {
		$this->name = $name;
		$this->model = $model;
		foreach ($config as $key => $value)
			$this->$key = $value;
	}

	public function renderGridFilter($htmlOptions=array()) {
		if ($this->filter)
			return $this->filter;
		$htmlOptions = CMap::mergeArray(array('id' => false), $htmlOptions);
		return CHtml::activeTextField($this->model, $this->name, $htmlOptions);
	}

	public function renderGridValue() {
		return CHtml::value($this->model, $this->name);
	}
	
	public function renderFormField($htmlOptions=array()){
		return CHtml::activeTextField($this->model, $this->name, $htmlOptions);
	}

}

class RAttributeTypeString extends RBaseAttributeType {
	
}

class RAttributeTypeText extends RBaseAttributeType {
	
}

class RAttributeTypeDate extends RBaseAttributeType {
	
}

class RAttributeTypeTime extends RBaseAttributeType {
	
}

class RAttributeTypeEnum extends RBaseAttributeType {

	private $_data;

	public function setData($data) {
		if (is_string($data))
			$this->_data = $this->evaluateExpression($data, array('data' => $this->model));
		else
			$this->_data = $data;
	}

	public function getData() {
		return $this->_data;
	}

	public function renderGridFilter($htmlOptions=array()) {
		if ($this->filter)
			return $this->filter;
		if ($this->data === null)
			throw new CDbException(Yii::t('yii', '{class} requires a data definition for the attribute "{name}".', array('{class}' => get_class($this), '{name}' => $this->name)));
		$htmlOptions = CMap::mergeArray(array(
					'id' => false,
					'prompt' => '',
						), $htmlOptions);
		return CHtml::activeDropDownList($this->model, $this->name, $this->data, $htmlOptions);
	}

	public function renderGridValue() {
		$value = CHtml::value($this->model, $this->name);
		return isset($this->data[$value]) ? $this->data[$value] : $value;
	}

	public function renderFormField($htmlOptions=array()){
		return CHtml::activeDropDownList($this->model, $this->name, $this->data, $htmlOptions);
	}
}