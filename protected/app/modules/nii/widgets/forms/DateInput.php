<?php

/**
 * Description of test
 *
 * @author robinwiliams
 */
class DateInput extends CInputWidget {

	public $showAmim = 'fold';

	public function init() {

	}

	public function run() {

		//Gets the name and id of the form item to be used throughout the run function.
		list($name, $id) = $this->resolveNameID();
		
		$inputDate = $this->model->getAttribute($this->attribute);

		$dateDay = $dateMonth = $dateYear = null;
		//Explodes the date into its various parts.
		if ($inputDate && $inputDate != '0000-00-00') {
			$date = explode('-', $inputDate);
			$dateDay = $date[2];
			$dateMonth = $date[1];
			$dateYear = $date[0];
		}

		//The visible part of the application.
		
		echo '<div id="'.$id.'_box">';
		echo $this->drawElement(CHtml::textField($id.'_day', $dateDay, array('class'=>$id.' datePickerDay inputInline','size'=>3,'maxlength'=>2)),$id.'_day','DD','field nopad inputInline','input w30');
		echo $this->drawElement(CHtml::textField($id.'_month', $dateMonth, array('class'=>$id.' datePickerMonth inputInline','size'=>4,'maxlength'=>2)),$id.'_month','MM','field nopad inputInline','input w30');
		echo $this->drawElement(CHtml::textField($id.'_year', $dateYear, array('class'=>$id.' datePickerYear inputInline','size'=>6,'maxlength'=>4)),$id.'_year','YYYY','field nopad inputInline','input w40');
		echo '<a href="#" style="display:inline-block;" id="'.$id.'_btn"><span class="icon fam-calendar"></span></a>';
		echo '</div>';

		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name' => $name,
			// additional javascript options for the date picker plugin
			'options' => array(
				'showAnim' => $this->showAmim,
				'dateFormat' => 'yy-mm-dd',
				'onSelect' => 'js:function(dateText) {
					var fullDate = $("#'.$id.'").datepicker("getDate");
					var day1 = leadingZeros(fullDate.getDate(),2);
					var month1 = leadingZeros(fullDate.getMonth() + 1,2);
					var year1 = fullDate.getFullYear();
					$("#'.$id.'_day").val(day1);
					$("#'.$id.'_month").val(month1);
					$("#'.$id.'_year").val(year1);
					$("#'.$id.'_box label.inFieldLabel").hide();
					}',
			),
			'htmlOptions' => array(
				'style' => 'visibility:hidden;height:0px;',
				'class'=>$id,
			),
			'value' => $inputDate
		));
		

		Yii::app()->clientScript->registerScript($this->getId(),
			'$(".' . $id . '").change(function() {
				var day = $("#' . $id . '_day").val();
				var month = $("#' . $id . '_month").val();
				var year = $("#' . $id . '_year").val();
				if (day && month && year) {
					var newDate = year+"-"+month+"-"+day;
					$("#'.$id.'").datepicker("setDate",newDate);
				} else if (!day && !month && !year) {
					$("#'.$id.'").datepicker("setDate",null);
				}
			});
			$("#'.$id.'_btn").click(function(){ $("#'.$id.'").datepicker("show"); });
			$("#'.$id.'_day").keyup( function(e) {
				var limit = $(this).attr("maxlength");
				var text = $(this).val();
				var chars = text.length;
				if(chars >= limit){
					if (e.keyCode == 16 || e.keyCode == 9) { return false; }
					$("#'.$id.'_month").focus();
				}
			});
			$("#'.$id.'_month").keyup( function(e) {
				var limit = $(this).attr("maxlength");
				var text = $(this).val();
				var chars = text.length;
				if(chars >= limit){
					if (e.keyCode == 16 || e.keyCode == 9) { return false; }
					$("#'.$id.'_year").focus();
				}
			});
			'
		);

	}
	
	public function drawElement ($contents, $id, $title, $outerClass=null, $innerClass=null) {
		
		$el  = '<div class="'.$outerClass.'"><label for="'.$id.'" class="inFieldLabel">'.$title.'</label><div class="'.$innerClass.'">';
		$el .= $contents;
		$el .= '</div></div>';
		
		return $el;
		
	}

}