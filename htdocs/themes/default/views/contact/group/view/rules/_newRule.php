<div class="line groupRule" id="rule-<?php echo $count ?>">
	<div class="unit size2of10 field">
		<div class="input">
			<?php echo CHtml::dropDownList('rule['.$count.'][grouping]', '', Yii::app()->getModule('contact')->ruleFieldGroupArray, array('id'=>'ruleGrouping-'.$count, 'class'=>'ruleGrouping', 'data-id'=>$count, 'prompt'=>'select grouping...')); ?>
		</div>
	</div>
	<div class="unit size3of10 field ruleFieldBox" id="ruleField-<?php echo $count ?>"><div class="input"><?php echo CHtml::dropDownList('','',array(),array('prompt'=>'select grouping first', 'disabled'=>'disabled'))?></div></div>
	<div class="unit size4of10 ruleSearchBox" id="ruleSearchBox-<?php echo $count ?>"><div class="input"><?php echo CHtml::dropDownList('','',array(),array('prompt'=>'select field first', 'disabled'=>'disabled'))?></div></div>
	<div class="lastUnit pts">
		<?php
		if ($count > 1)
			$deleteOptions = array('class'=>'groupRuleDelete');
		else
			$deleteOptions = array('class'=>'groupRuleDelete hidden');
		
		echo NHtml::btnLink('','#', 'fam-add', array('class'=>'groupRuleAdd'));
		echo NHtml::btnLink('','#', 'fam-delete', $deleteOptions);
		?>
	</div>
</div>