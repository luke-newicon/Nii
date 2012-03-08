<?php

class LHtml extends CHtml {

	public static function activeField($model, $attribute, $htmlOptions=array()){
		if($model instanceof LActiveRecord)
			return $model->getDefinition($attribute)->renderField($htmlOptions);
		else
			return self::activeTextField($model, $attribute, $htmlOptions);
	}
	
	public static function activeValue($model, $attribute){
		if($model instanceof LActiveRecord)
			return $model->getDefinition($attribute)->renderValue();
		else
			return self::value($model, $attribute);;
	}
	
	public static function markdown() {
		// todo add nii input widget
	}

	public static function wysiwyg() {
		// todo add nii input widget
	}
	
	/**
	 * Creates a form date field
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $options Additional options to be passed into the datePicker widget
	 * @return CInputWidget
	 */
	public static function dateField($model, $attribute, $options = array()) {
		$options['model'] = $model;
		$options['attribute'] = $attribute;
		return $this->widget('nii.widgets.forms.DateInput', $options, true);
	}

	public static function autoComplete($model, $attribute, $source, $alt_attribute = null, $options = array()) {
		$options['source'] = $source;
		$options['name'] = $alt_attribute ? $alt_attribute : $attribute;
		$options['value'] = $alt_attribute ? CHtml::resolveValue($model, $alt_attribute) : CHtml::resolveValue($model, $attribute);
		if (!isset($options['options'])) {
			$hidden_field_id = get_class($model) . '_' . $attribute;
			$options['options'] = array(
				'showAnim' => 'fold',
				'change' => 'js:function(event, ui) {
					if (ui.item)
						$("#' . $hidden_field_id . '").val(ui.item.id);
					else
						$("#' . $hidden_field_id . '").val(null);
				}',
			);
		}
		$return = $this->widget('zii.widgets.jui.CJuiAutoComplete', $options, true);
		if ($alt_attribute)
			$return .= $this->hiddenField($model, $attribute);
		return $return;
	}

}