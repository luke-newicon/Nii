<?php
$field = current($fields);
?>
<div class="line customScope" id="filter-<?php echo $count; ?>">
	<div class="unit pls mtm mrs filterCount w20"><?php echo $count; ?></div>
	<div class="unit prm">
		<div class="field">
			<div class="inputBox w150"><?php echo CHtml::dropDownList('rule['.$count.'][field]', '', $fields, array('id'=>'filterField-'.$count, 'class'=>'filterField', 'data-id'=>$count)); ?>
			</div>
		</div>
	</div>
	<div id="filterFields-<?php echo $count; ?>">
	<?php $this->renderPartial('ajax/_filter_fields', array('model'=>$model, 'field'=>$field, 'id'=>$count));  ?>
	</div>
	<div class="lastUnit pts">
		<?php
		if ($count > 1)
			$deleteOptions = array('class'=>'customScopeDelete');
		else
			$deleteOptions = array('class'=>'customScopeDelete hidden');
		
		echo NHtml::btnLink('','#', 'icon fam-add', array('class'=>'customScopeAdd'));
		echo NHtml::btnLink('','#', 'icon fam-delete', $deleteOptions);
		?>
	</div>
</div>