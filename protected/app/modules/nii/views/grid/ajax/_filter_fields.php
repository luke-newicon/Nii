<?php
$scope = new CustomScope;
$filter = '';
if (!is_object($model))
	$model = new $model;
foreach($model->columns(array()) as $column) {
	if ($column['name']==$field && is_array($column['filter']))
		$filter = $column['filter'];
}
?>
<div class="unit prm">
	<div class="field">
		<div class="input w70">
			<?php 
			foreach ($scope->searchMethods as $method) {
				if (!is_array($filter) || (is_array($filter) && $method['useForDropdown']))					
					$methods[$method['value']] = $method['label'];
			}
			echo CHtml::dropDownList('rule['.$id.'][searchMethod]', $scope->defaultSearchMethod, $methods, array('class'=>'searchMethod')); ?>
		</div>
	</div>
</div>
<div class="unit prm">
	<div class="field">
		<div class="input w200 filterValue" id="filterValue-<?php echo $id; ?>">
			<?php 
			if (is_array($filter))
				echo CHtml::dropDownList('rule['.$id.'][value]', '', $filter);
			else
				echo CHtml::textField('rule['.$id.'][value]', '', array('class'=>'filterValue')); 
			?>
		</div>
	</div>
</div>
