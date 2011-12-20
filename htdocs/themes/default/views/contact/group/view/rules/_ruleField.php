<div class="input w150">
	<?php echo CHtml::dropDownList('rule['.$count.'][field]', '', $ruleModel->getRuleFieldsDropdown($grouping), array('id'=>'ruleField-'.$count, 'class'=>'ruleField', 'data-id'=>$count, 'prompt'=>'select field...')); ?>
</div>