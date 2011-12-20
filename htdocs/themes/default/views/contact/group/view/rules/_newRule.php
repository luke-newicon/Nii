<?php $form = $this->beginWidget('NActiveForm', array(
	'id' => 'groupRulesForm',
	'enableAjaxValidation' => false,
)); ?>
<div class="line groupRule" id="rule-<?php echo $count ?>">
	<div class="unit size1of4 field">
		<div class="input">
			<?php echo CHtml::dropDownList('rule['.$count.'][grouping]', '', Yii::app()->getModule('contact')->ruleFieldGroupArray, array('id'=>'ruleGrouping-'.$count, 'class'=>'ruleGrouping', 'data-id'=>$count, 'prompt'=>'select grouping...')); ?>
		</div>
	</div>
	<div class="unit size1of4 field" id="ruleField-<?php echo $count ?>"></div>
	<div class="lastUnit" id="ruleSearchBox-<?php echo $count ?>"></div>
</div>
<?php $this->endWidget(); ?>