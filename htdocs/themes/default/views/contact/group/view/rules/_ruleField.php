<div class="input">
	<?php echo CHtml::dropDownList('rule['.$count.'][field]', '', $ruleModel->getRuleFieldsDropdown($grouping), array('class'=>'ruleField', 'data-id'=>$count, 'prompt'=>'select field...')); ?>
</div>