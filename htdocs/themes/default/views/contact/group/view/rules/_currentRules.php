<?php
$count = 1;
foreach ($groupRules['rule'] as $key => $rule) { 
	$grouping = $rule['grouping'];
	$field = $rule['field'];
	?>
	<div class="line groupRule" id="rule-<?php echo $count ?>">
		<div class="unit size2of10 field">
			<div class="input">
				<?php echo CHtml::dropDownList('rule['.$count.'][grouping]', $grouping, Yii::app()->getModule('contact')->ruleFieldGroupArray, array('id'=>'ruleGrouping-'.$count, 'class'=>'ruleGrouping', 'data-id'=>$count, 'prompt'=>'select grouping...')); ?>
			</div>
		</div>
		<div class="unit size3of10 field ruleFieldBox" id="ruleField-<?php echo $count ?>">
			<div class="input">
				<?php echo CHtml::dropDownList('rule['.$count.'][field]', $field, $ruleModel->getRuleFieldsDropdown($grouping), array('id'=>'ruleField-'.$count, 'class'=>'ruleField', 'data-id'=>$count, 'prompt'=>'select field...')); ?>
			</div>	
		</div>
		<div class="unit size4of10 ruleSearchBox" id="ruleSearchBox-<?php echo $count ?>">
			<div class="unit size1of4 field">
				<div class="input">
					<?php echo CHtml::dropDownList(
						'rule['.$count.'][searchMethod]', 
						$rule['searchMethod'], 
						$ruleModel->getSearchOperators($grouping, $field), 
						array('id'=>'searchMethod-'.$count, 'class'=>'searchMethod', 'data-id'=>$count)
					); ?>
				</div>
			</div>
			<div class="lastUnit field">
				<div class="input">
					<?php // @todo: Create function for displaying the correct group rule search box 
					echo $ruleModel->drawSearchBox($grouping, $field, $count, $rule['value']);
					?>
				</div>
			</div>
		</div>
		<div class="lastUnit pts">
			<?php
			if (count($groupRules['rule']) > 1)
				$deleteOptions = array('class'=>'groupRuleDelete icon fam-delete');
			else
				$deleteOptions = array('class'=>'groupRuleDelete icon fam-delete hidden');

			echo NHtml::link('','#', array('class'=>'groupRuleAdd icon fam-add'));
			echo NHtml::link('','#', $deleteOptions);
			?>
		</div>
	</div>
	<?php
	$count++;
} ?>