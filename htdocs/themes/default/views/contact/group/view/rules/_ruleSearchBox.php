<div class="unit size1of4 field">
	<div class="input">
		<?php echo CHtml::dropDownList(
			'rule['.$count.'][operator]', 
			$ruleModel->defaultSearchMethod, 
			$ruleModel->getSearchOperators($grouping, $field), 
			array('id'=>'ruleOperator-'.$count, 'class'=>'ruleOperator', 'data-id'=>$count)
		); ?>
	</div>
</div>
<div class="lastUnit field">
	<div class="input">
		<?php // @todo: Create function for displaying the correct group rule search box 
		echo $ruleModel->drawSearchBox($grouping, $field);
		?>
	</div>
</div>