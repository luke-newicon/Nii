<?php

/**
 * Description of test
 * 
 * 
 * @param string $value expects the value or attribute to be a mysql date format string YYYY-MM-DD
 * @author robinwiliams
 */
class DateInput extends CInputWidget 
{

	public $showAmim = 'fold';

	public function init() {
		
	}

	public function run() {

		// Gets the name and id of the form item to be used throughout the run function.
		list($name, $id) = $this->resolveNameID();
		if($this->hasModel()){
			$dateTime = $this->model->getAttribute($this->attribute);
		}else{
			$dateTime = $this->value;
		}
		$dateTime = explode(' ',$dateTime);
		$inputDate = $dateTime[0];

		$dateDay = $dateMonth = $dateYear = null;
		// Explodes the date into its various parts.
		if ($inputDate && $inputDate != '0000-00-00') {
			$date = explode('-', $inputDate);
			$dateDay = $date[2];
			$dateMonth = $date[1];
			$dateYear = $date[0];
		}

		// The visible part of the application.

		$day_field = CHtml::textField($id . '_day', $dateDay, array(
					'class' => $id . ' datePickerDay',
					'maxlength' => 2,
					'style' => 'width:20px;margin-right:4px;',
					'placeholder'=>'DD',
				));
		$month_field = CHtml::textField($id . '_month', $dateMonth, array(
					'class' => $id . ' datePickerMonth',
					'maxlength' => 2,
					'style' => 'width:25px;;margin-right:4px;',
					'placeholder'=>'MM',
				));
		$year_field = CHtml::textField($id . '_year', $dateYear, array(
					'class' => $id . ' datePickerYear',
					'size' => 6,
					'maxlength' => 4,
					'style' => 'width:35px;',
					'placeholder'=>'YYYY',
				));

		echo '<div id="' . $id . '_box" style="overflow:hidden">';
		echo '<div style="float:left;margin-right:4px;">' . $day_field . '<span>/</span></div>';
		echo '<div style="float:left;margin-right:4px;">' . $month_field . '<span>/</span></div>';
		echo '<div style="float:left;margin-right:5px;"">' . $year_field . '</div>';
		echo '<a href="#" style="display:inline-block;margin-top:4px" id="' . $id . '_btn"><span class="icon fam-calendar"></span></a>';
		echo '</div>';

		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name' => $name,
			// additional javascript options for the date picker plugin
			'options' => array(
				'showAnim' => $this->showAmim,
				'dateFormat' => 'yy-mm-dd',
				'onSelect' => 'js:function(dateText) {
					var fullDate = $("#' . $id . '").datepicker("getDate");
					var day1 = nii.leadingZeros(fullDate.getDate(),2);
					var month1 = nii.leadingZeros(fullDate.getMonth() + 1,2);
					var year1 = fullDate.getFullYear();
					$("#' . $id . '_day").val(day1);
					$("#' . $id . '_month").val(month1);
					$("#' . $id . '_year").val(year1);
					//$("#' . $id . '_box label.inFieldLabel").hide();
				}',
			),
			'htmlOptions' => array(
				'style' => 'visibility:hidden;height:0px;margin:-10px 0 0;display:block',
				'class' => $id,
			),
			'value' => $inputDate
		));


		Yii::app()->clientScript->registerScript($this->getId(), '$(".' . $id . '").change(function() {
				var day = $("#' . $id . '_day").val();
				var month = $("#' . $id . '_month").val();
				var year = $("#' . $id . '_year").val();
				if (day && month && year) {
					var newDate = year+"-"+month+"-"+day;
					$("#' . $id . '").datepicker("setDate",newDate);
				} else if (!day && !month && !year) {
					$("#' . $id . '").datepicker("setDate",null);
				}
			});
			$("#' . $id . '_btn").click(function(){
				$("#' . $id . '").datepicker("show");
				return false;
			});
			$("#' . $id . '_day").keyup( function(e) {
				var limit = $(this).attr("maxlength");
				var text = $(this).val();
				var chars = text.length;
				if(chars >= limit){
					if (e.keyCode == 16 || e.keyCode == 9) { return false; }
					$("#' . $id . '_month").focus();
				}
			});
			$("#' . $id . '_month").keyup( function(e) {
				var limit = $(this).attr("maxlength");
				var text = $(this).val();
				var chars = text.length;
				if(chars >= limit){
					if (e.keyCode == 16 || e.keyCode == 9) { return false; }
					$("#' . $id . '_year").focus();
				}
			});
			'
		);
	}

	public function drawElement($contents, $id, $title, $outerClass=null, $innerClass=null)
	{
		return '<div style="float:left;"><div class="input-prepend" style="margin:0 3px 0 0"><span class="add-on">' . $title . '</span>' . $contents . '</div></div>';
	}

}