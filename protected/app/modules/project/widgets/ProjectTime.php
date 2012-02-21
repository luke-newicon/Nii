<?php

/**
 * ProjectTime class file.
 *
 * @author Steven O'Brien <steven.obrien@newicon.net>
 * @link http://newicon.net/framework
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */

/**
 * ProjectTime input widget enables a user to enter in a total time
 * in hours, minutes, or days
 * the widget then converts this to minutes.
 *
 * @author steve
 */
class ProjectTime extends CInputWidget 
{
	
	public $hoursPerDay = 7.5;
	
	public $daysPerWeek = 5;
	
	public $defaultUnit = 'hours';
	
	public function run()
	{
		list($name, $id) = $this->resolveNameID();
		if($this->hasModel()){
			$value = $this->model->{$this->attribute};
		}else{
			$value = $this->value;
		}
		$value = $this->value;
		
		
		$minPerWeek = ($this->daysPerWeek*$this->hoursPerDay*60);
		$minPerDay = ($this->hoursPerDay*60);
		
		$weeks = $value / $minPerWeek; $weeksR = $value % $minPerWeek;
		$days = $value / $minPerDay; $daysR = $value % $minPerDay;
		$hours = $value / 60; $hoursR = $value % 60;
		
		if(empty($value)){
			$type = $this->defaultUnit;
	    }elseif($value < 60){
			$type = 'minutes';
		}elseif($weeks>=1 && $weeksR==0){
			$type = 'weeks';
		}elseif($days>=1 && $daysR==0){
			$type = 'days';
		}elseif($hours>=1 && $hoursR==0){
			$type = 'hours';
		}
			
		if($type=='hours'){
			$value = $hours;
		}elseif($type=='days'){
			$value = $days;
		}elseif($type=='weeks'){
			$value = $weeks;
		}
		
		
		// value is always minutes
		echo CHtml::textField($id.'[int]', $value, array('class'=>'input-mini'));
		echo CHtml::dropDownList($id.'[type]',$type,array('minutes'=>'minutes','hours'=>'hours','days'=>'days','weeks'=>'weeks'),array('class'=>'input-small'));
		echo CHtml::hiddenField($id, $value);
		
		Yii::app()->clientScript->registerScript($this->getId(), '
			$("#'.$id.'_int,#'.$id.'_type").change(function(){
				// convert to minutes based on type
				var type = $("#'.$id.'_type").val();
				var inc = $("#'.$id.'_int").val();
				if(type == "days")
					mins = inc * '.$minPerDay.';
				if(type == "weeks")
					mins = inc * '.$minPerWeek.';
				if(type == "hours")
					mins = inc * 60;
				$("#'.$id.'").val(mins);
			})
		');
	}
}
