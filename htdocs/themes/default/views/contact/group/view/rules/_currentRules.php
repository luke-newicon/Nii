<?php
$count = 1;

foreach ($groupRules['rule'] as $rule) { 
	
	$filter='';
	$filterField = '';
	foreach($model->columns(array()) as $column) {
		$filterField = (isset($column['filter'])?$column['filter']:'');
		if ($column['name']==$rule['field'] && is_array($filterField))
			$filter = $filterField;
	}
	?>

	<div class="line groupRules" id="filter-<?php echo $count; ?>">
		<div class="unit pls mtm mrs filterCount w20"><?php echo $count; ?></div>
		<div class="unit prm">
			<div class="field">
				<div class="input w150"><?php echo CHtml::dropDownList('rule['.$count.'][field]', $rule['field'], $fields, array('id'=>'filterField-'.$count, 'class'=>'filterField', 'data-id'=>$count)); ?>
				</div>
			</div>
		</div>
		
		<div id="filterFieldsGroup-<?php echo $count; ?>">
			<div class="unit prm">
				<div class="field">
					<div class="input w70">
						<?php 
						foreach ($ruleModel->searchMethods as $method) {
							if (!is_array($filter) || (is_array($filter) && $method['useForDropdown']))					
								$methods[$method['value']] = $method['label'];
						}
						echo CHtml::dropDownList('rule['.$count.'][searchMethod]', $rule['searchMethod'], $methods, array('class'=>'searchMethod')); ?></div>
				</div>
			</div>
			<div id="filterFields-<?php echo $count; ?>">
			<div class="unit prm">
				<div class="field">
					<div class="input w70">
						<?php 
						foreach ($ruleModel->searchMethods as $method) {
							if (!is_array($filter) || (is_array($filter) && $method['useForDropdown']))					
								$methods[$method['value']] = $method['label'];
						}
						echo CHtml::dropDownList('rule['.$count.'][searchMethod]', $rule['searchMethod'], $methods, array('class'=>'searchMethod')); ?></div>
				</div>
			</div>
			<div class="unit prm">
				<div class="field">
					<div class="input w200 filterValue" id="filterValue-<?php echo $count; ?>">
						<?php 

						if (is_array($filter))
							echo CHtml::dropDownList('rule['.$count.'][value]', $rule['value'], $filter);
						else
							echo CHtml::textField('rule['.$count.'][value]', $rule['value'], array('class'=>'filterValue')); 
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="lastUnit pts">
			<?php
			if (next($groupRules['rule']) || $count > 1)
				$deleteOptions = array('class'=>'groupRulesDelete');
			else
				$deleteOptions = array('class'=>'groupRulesDelete hidden');

			echo NHtml::btnLink('','#', 'icon fam-add', array('class'=>'groupRulesAdd'));
			echo NHtml::btnLink('','#', 'icon fam-delete', $deleteOptions);
			?>
		</div>
	</div>
	<?php
	$count++;
} ?>