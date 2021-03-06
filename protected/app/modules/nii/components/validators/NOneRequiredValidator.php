<?php
/**
 * CRequiredValidator class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CRequiredValidator validates that the specified attribute does not have null or empty value.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CRequiredValidator.php 2799 2011-01-01 19:31:13Z qiang.xue $
 * @package system.validators
 * @since 1.0
 */
class NOneRequiredValidator extends CValidator
{
	/**
	 * @var mixed the desired value that the attribute must have.
	 * If this is null, the validator will validate that the specified attribute does not have null or empty value.
	 * If this is set as a value that is not null, the validator will validate that
	 * the attribute has a value that is the same as this property value.
	 * Defaults to null.
	 * @since 1.0.10
	 */
	public $requiredValue;
	/**
	 * @var boolean whether the comparison to {@link requiredValue} is strict.
	 * When this is true, the attribute value and type must both match those of {@link requiredValue}.
	 * Defaults to false, meaning only the value needs to be matched.
	 * This property is only used when {@link requiredValue} is not null.
	 * @since 1.0.10
	 */
	public $strict=false;


	/**
	 * Validates the specified object.
	 * @param CModel $object the data object being validated
	 * @param array $attributes the list of attributes to be validated. Defaults to null,
	 * meaning every attribute listed in {@link attributes} will be validated.
	 */
	public function validate($object,$attributes=null)
	{
		foreach($this->attributes as $i => $a){
			if(!$this->isEmpty($object->$a))
				return;
		}
		// if we get this far then all of the attributes are empty.
		foreach($this->attributes as $attribute){
			$message=$this->message!==null?$this->message:Yii::t('yii','At least one of these fields is required.');
			$this->addError($object, $attribute, $message);
		}
		
	}

	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel $object the object being validated
	 * @param string $attribute the attribute being validated
	 */
	protected function validateAttribute($object,$attribute)
	{
		// be silent! validation handled by validate method as it validates the group of attributes
	}
}
