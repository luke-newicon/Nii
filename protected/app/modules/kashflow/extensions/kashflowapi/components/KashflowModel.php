<?php

class KashflowModel extends CFormModel {

	public $_attributes;

	/**
	 * Returns all attribute values.
	 * @param array $names list of attributes whose value needs to be returned.
	 * Defaults to null, meaning all attributes as listed in {@link attributeNames} will be returned.
	 * If it is an array, only the attributes in the array will be returned.
	 * @return array attribute values (name=>value).
	 */
	public function getAttributes($names=null) {
		$values = $this->_attributes;
		foreach ($this->attributeNames() as $name)
			$values[$name] = $this->$name;

		if (is_array($names)) {
			$values2 = array();
			foreach ($names as $name)
				$values2[$name] = isset($values[$name]) ? $values[$name] : null;
			return $values2;
		}
		else
			return $values;
	}

	/**
	 * PHP getter magic method.
	 * This method is overridden so that any missing properties will be stored in the attributes array.
	 * @param string $name property name
	 * @return mixed property value
	 * @see getAttribute
	 */
	public function __get($name) {
		if ($this->hasAttribute($name))
			return $this->_attributes[$name];
		else
			return parent::__get($name);
	}

	/**
	 * PHP setter magic method.
	 * This method is overridden so that AR attributes can be accessed like properties.
	 * @param string $name property name
	 * @param mixed $value property value
	 */
	public function __set($name, $value) {
		$this->setAttribute($name, $value);
	}

	/**
	 * Checks if a property value is null.
	 * This method overrides the parent implementation by checking
	 * if the named attribute is null or not.
	 * @param string $name the property name or the event name
	 * @return boolean whether the property value is null
	 * @see hasAttribute
	 */
	public function __isset($name) {
		if ($this->hasAttribute($name))
			return true;
		else
			return parent::__isset($name);
	}

	/**
	 * Sets a component property to be null.
	 * This method overrides the parent implementation by clearing
	 * the specified attribute value.
	 * @param string $name the property name or the event name
	 * @see hasAttribute
	 */
	public function __unset($name) {
		if ($this->hasAttribute($name))
			unset($this->_attributes[$name]);
		else
			parent::__unset($name);
	}

	/**
	 * Checks whether this AR has the named attribute
	 * @param string $name attribute name
	 * @return boolean whether this AR has the named attribute (table column).
	 */
	public function hasAttribute($name) {
		return isset($this->_attributes[$name]);
	}

	/**
	 * Returns the named attribute value.
	 * You may also use $this->AttributeName to obtain the attribute value.
	 * @param string $name the attribute name
	 * @return mixed the attribute value. Null if the attribute is not set or does not exist.
	 * @see hasAttribute
	 */
	public function getAttribute($name) {
		if (property_exists($this, $name))
			return $this->$name;
		else if ($this->hasAttribute($name))
			return $this->_attributes[$name];
	}

	/**
	 * Sets the named attribute value.
	 * You may also use $this->AttributeName to set the attribute value.
	 * @param string $name the attribute name
	 * @param mixed $value the attribute value.
	 * @return boolean whether the attribute exists and the assignment is conducted successfully
	 */
	public function setAttribute($name, $value) {
		if (property_exists($this, $name))
			$this->$name = $value;
		else
			$this->_attributes[$name] = $value;
		return true;
	}

}