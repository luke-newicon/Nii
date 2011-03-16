<?php

/**
 * Description of test
 *
 * @author matthewturner
 */
class TimeAndDate extends CInputWidget {

	public $seconds = false;

	public $showAmim = 'fold';

	public function init() {

	}

	public function run() {
		//Sets the variables up to be null by default.
		$inputMinute = $inputSeconds = $inputHour = $inputDate = null;

		//Gets the name and id of the form item to be used throughout the run function.
		list($name, $id) = $this->resolveNameID();

		//Explodes the date into its various parts.
		if ($this->model->getAttribute($this->attribute)) {
			$date = explode(' ', $this->model->getAttribute($this->attribute));
			$inputDate = $date[0];
			$time = explode(':', $date[1]);
			$inputHour = $time[0];
			$inputMinute = $time[1];
		}

		Yii::app()->clientScript->registerScript($this->getId(),
			'$(".' . $id . '").change(function() {
				var date = $("#' . $id . '_date").val();
				var hours = $("#' . $id . '_hours :selected").text();
				var mins = $("#' . $id . '_minutes :selected").text();
				$("#' . $id . '").val(date+" "+hours+":"+mins+":00");
			});'
		);

		//The visible part of the application.
		echo '<div> Date: ';
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name' => $id . '_date',
			// additional javascript options for the date picker plugin
			'options' => array(
				'showAnim' => $this->showAmim,
				'dateFormat' => 'yy-mm-dd'
			),
			'htmlOptions' => array(
				'style' => 'height:20px;'
			),
			'htmlOptions'=>array('class'=>$id),
			'value' => $inputDate
		));

		echo ' Time: ';
		echo chtml::dropDownList($id . '_hours', $inputHour,  $this->timeRange(24), array('class' => $id));
		echo ' : ';
		echo chtml::dropDownList($id . '_minutes', $inputMinute, $this->timeRange(60), array('class' => $id));
		if ($this->seconds) {
			echo ' : ';
			echo chtml::dropDownList($id . '_seconds', $inputSeconds, $this->timeRange(60),array('class' => $id));
		}
		echo chtml::activeHiddenField($this->model, $this->attribute);
	}


	public function timeRange($limit){
		$m = array();
		for($i=0; $i<$limit; $i++){
			$v = sprintf("%02d",$i);
			$m[$v] = $v;
		}
		return $m;
	}

}

?>
