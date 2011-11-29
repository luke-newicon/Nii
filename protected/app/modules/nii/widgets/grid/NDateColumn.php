<?php

Yii::import('zii.widgets.grid.NDataColumn');
/**
 * Description of NDataColumn
 *
 * @author robinwilliams
 */
class NDateColumn extends NDataColumn {



	/**
	 * Renders the filter cell content.
	 * This method will render the {@link filter} as is if it is a string.
	 * If {@link filter} is an array, it is assumed to be a list of options, and a dropdown selector will be rendered.
	 * Otherwise if {@link filter} is not false, a text field is rendered.
	 */
	protected function renderFilterCellContent() {
		
		$model = $this->grid->filter;
		$class = get_class($model);
		
		$from = $this->name.'_from';
		$to = $this->name.'_to';
		
		$controller = Yii::app()->controller;
		
		echo '<div class="line field mbs"><div class="input inputInline">';
			// From date
		$controller->widget('zii.widgets.jui.CJuiDatePicker', array(
				'name' => $class.'['.$from.']',
				'value' => $model->$from,
				// additional javascript options for the date picker plugin
				'options'=>array(
					'showAnim'=>'fold',
					'dateFormat'=>'yy-mm-dd',
					'constrainInput' => 'false',
					'onClose' => 'js:function(selectedDate) {
						var instance = jQuery(this).data("datepicker");
						var date = jQuery.datepicker.parseDate(instance.settings.dateFormat || jQuery.datepicker._defaults.dateFormat, selectedDate, instance.settings );
						jQuery("#'.$class.'_'.$to.'").datepicker( "option", "minDate", date );
					}',
				),
				'htmlOptions'=>array(
					'placeholder'=>'From',
					'style'=>'height:20px;width:70px;',
				),
			)); 
			
		echo '</div></div><div class="line field mbn"><div class="input inputInline">';
			
			// To date
		$controller->widget('zii.widgets.jui.CJuiDatePicker', array(
				'name' => $class.'['.$to.']',
				'value' => $model->$to,
				// additional javascript options for the date picker plugin
				'options'=>array(
					'showAnim'=>'fold',
					'dateFormat'=>'yy-mm-dd',
					'constrainInput' => 'false',
					'onClose' => 'js:function(selectedDate) {
						var instance = jQuery(this).data("datepicker");
						var date = jQuery.datepicker.parseDate(instance.settings.dateFormat || jQuery.datepicker._defaults.dateFormat, selectedDate, instance.settings );
						jQuery("#'.$class.'_'.$from.'").datepicker( "option", "maxDate", date );
					}',
				),
				'htmlOptions'=>array(
					'placeholder'=>'To',
					'style'=>'height:20px;width:70px',
				),
			));
		echo '</div></div>';
	}
	
}