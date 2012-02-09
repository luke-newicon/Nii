<?php

/**
 * NActiveForm class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
class NActiveForm extends CActiveForm {

	public $enableAjaxValidation = true;
	public $enableClientValidation = true;
	public $errorMessageCssClass = 'errorMessage help-inline';

	public function init() {
		// add small script to add focus class to parent .field element
		if (!isset($this->clientOptions['inputContainer']))
			$this->clientOptions['inputContainer'] = '.control-group';
		if (!isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] = 'form-horizontal';
		parent::init();
	}

	public function markdown() {
		// todo add nii input widgets
	}

	public function wysiwyg() {
		// todo add nii input widget
	}

	/**
	 * Renders an HTML label for a model attribute.
	 * This method is a wrapper of {@link CHtml::activeLabelEx}.
	 * Please check {@link CHtml::activeLabelEx} for detailed information
	 * about the parameters for this method.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes.
	 * @return string the generated label tag
	 */
	public function labelEx($model, $attribute, $htmlOptions=array()) {
		if (empty($htmlOptions)) {
			$htmlOptions = array('class' => 'control-label');
		}
		return parent::labelEx($model, $attribute, $htmlOptions);
	}

	public function field($model, $attribute, $type='textField', $data=null, $htmlOptions=array()) {
		return $this->editField($model, $attribute, $type, $data, $htmlOptions);
	}

	/**
	 * Creates a form field using a default structure for labels, field and error message
	 * @param CModel $model the data model
	 * @param string $attribute The attribute to display
	 * @param string $type The type of field you want i.e textField, dropDownList
	 * @param array $data Required for dropDownList type
	 * @param array $htmlOptions Any optional HTML options to be applied
	 * @return string The HTML to be rendered
	 */
	public function editField($model, $attribute, $type='textField', $data=null, $htmlOptions=array()) {
		$error = $model->hasErrors($attribute) ? ' error' : '';
		$return = '<div class="control-group' . $error . '">';
		$return .= $this->labelEx($model, $attribute);
		$return .= '<div class="controls">';
		if ($type == 'dropDownList') {
			$return .= $this->dropDownList($model, $attribute, $data, $htmlOptions);
		} else
			$return .= $this->$type($model, $attribute, $htmlOptions);
		$return .= $this->error($model, $attribute);
		$return .= '</div></div>';
		return $return;
	}

	/**
	 * Creates a field using a default structure for labels and text
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data When the attribute is a represented by a array lookup i.e select boxes
	 * @return string The HTML output 
	 */
	public function viewField($model, $attribute, $data=array()) {
		$return = '<div class="control-group">';
		$return .= $this->labelEx($model, $attribute);
		$return .= '<div class="controls">';
		$value = CHtml::resolveValue($model, $attribute);
		$return .= (array_key_exists($value, $data) ? $data[$value] : $value);
		$return .= '</div></div>';
		return $return;
	}

	/**
	 * Creates a checkbox field
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @return string HTML output 
	 */
	public function checkBoxField($model, $attribute) {
		return $this->labelEx($model, $attribute, array(
					'label' => $this->checkBox($model, $attribute) . $model->getAttributeLabel($attribute),
					'class' => 'checkbox',
				));
	}

	/**
	 * Creates a form date field
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $options Additional options to be passed into the datePicker widget
	 * @return CInputWidget
	 */
	public function dateField($model, $attribute, $options=array()) {
		$options['model'] = $model;
		$options['attribute'] = $attribute;
		return $this->widget('nii.widgets.forms.DateInput', $options, true);
	}

}