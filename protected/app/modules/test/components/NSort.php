<?php

class NSort extends CSort {

	/**
	 * @var array separators used in the generated URL. This must be an array consisting of
	 * two elements. The first element specifies the character separating different
	 * attributes, while the second element specifies the character separating attribute name
	 * and the corresponding sort direction. Defaults to array('-','.').
	 */
	public $separators = array('-', ':');
	
	public $model;

	/**
	 * Returns the real definition of an attribute given its name.
	 *
	 * The resolution is based on {@link attributes} and {@link CActiveRecord::attributeNames}.
	 * <ul>
	 * <li>When {@link attributes} is an empty array, if the name refers to an attribute of {@link modelClass},
	 * then the name is returned back.</li>
	 * <li>When {@link attributes} is not empty, if the name refers to an attribute declared in {@link attributes},
	 * then the corresponding virtual attribute definition is returned. Starting from version 1.1.3, if {@link attributes}
	 * contains a star ('*') element, the name will also be used to match against all model attributes.</li>
	 * <li>In all other cases, false is returned, meaning the name does not refer to a valid attribute.</li>
	 * </ul>
	 * @param string $attribute the attribute name that the user requests to sort on
	 * @return mixed the attribute name or the virtual attribute definition. False if the attribute cannot be sorted.
	 */
	public function resolveAttribute($attribute)
	{
		if($this->attributes!==array())
			$attributes=$this->attributes;
		else if(strpos($attribute,'.')) {
			$relation = array_shift(explode('.', $attribute));
			if(is_object($this->model->$relation))
				return $attribute;
			else
				return false;
		} else if($this->modelClass!==null)
			$attributes=CActiveRecord::model($this->modelClass)->attributeNames();
		else
			return false;
		foreach($attributes as $name=>$definition)
		{
			if(is_string($name))
			{
				if($name===$attribute)
					return $definition;
			}
			else if($definition==='*')
			{
				if($this->modelClass!==null && CActiveRecord::model($this->modelClass)->hasAttribute($attribute))
					return $attribute;
			}
			else if($definition===$attribute)
				return $attribute;
		}
		return false;
	}
}